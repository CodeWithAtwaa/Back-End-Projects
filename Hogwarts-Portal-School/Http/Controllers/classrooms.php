<?php

use Core\App;
use Http\Models\DashboardModel;

$role = user_role();

if ($role === 'Student') {
    $db = App::resolve('Core\Database');
    $userId = current_user()['user_id'] ?? null;

    $student = $db->query('SELECT
            Student.student_id,
            User.user_name,
            House.house_name
            FROM Student
            JOIN User ON Student.user_id = User.user_id
            JOIN House ON Student.house_id = House.house_id
            WHERE Student.user_id = :user_id
        ', ['user_id' => $userId])->find();

    if (!$student) {
        abort(403);
    }

    $courses = $db->query('SELECT
            Course.course_id,
            Course.course_name,
            Professor.professor_name,
            Enrollment.enrolled_at,
            Enrollment.status,
            COUNT(DISTINCT Assignment.assignment_id) AS assignments_count,
            COUNT(DISTINCT Submission.submission_id) AS submissions_count
            FROM Enrollment
            JOIN Course ON Enrollment.course_id = Course.course_id
            JOIN Professor ON Course.professor_id = Professor.professor_id
            LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
            LEFT JOIN Submission
                ON Assignment.assignment_id = Submission.assign_id
                AND Submission.student_id = Enrollment.student_id
            WHERE Enrollment.student_id = :student_id
            GROUP BY Course.course_id, Course.course_name, Professor.professor_name, Enrollment.enrolled_at, Enrollment.status
            ORDER BY Enrollment.enrolled_at DESC
        ', ['student_id' => $student['student_id']])->get();

    $availableCourses = $db->query('SELECT
            Course.course_id,
            Course.course_name,
            Professor.professor_name,
            Enrollment.status AS enrollment_status,
            COUNT(DISTINCT Assignment.assignment_id) AS assignments_count
            FROM Course
            JOIN Professor ON Course.professor_id = Professor.professor_id
            LEFT JOIN Enrollment
                ON Course.course_id = Enrollment.course_id
                AND Enrollment.student_id = :student_id
            LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
            GROUP BY Course.course_id, Course.course_name, Professor.professor_name, Enrollment.status
            ORDER BY Course.course_name
        ', ['student_id' => $student['student_id']])->get();

    $assignments = $db->query('SELECT
            Assignment.assignment_id,
            Assignment.title,
            Assignment.assignment_type,
            Assignment.max_points,
            Assignment.deadline,
            Assignment.created_at,
            Course.course_id,
            Course.course_name,
            Professor.professor_name,
            Submission.submission_id,
            Submission.score,
            Submission.submitted_at,
            CASE
                WHEN Submission.submission_id IS NOT NULL THEN "Submitted"
                WHEN Assignment.deadline < NOW() THEN "Overdue"
                ELSE "Pending"
            END AS student_status
            FROM Enrollment
            JOIN Course ON Enrollment.course_id = Course.course_id
            JOIN Professor ON Course.professor_id = Professor.professor_id
            JOIN Assignment ON Course.course_id = Assignment.course_id
            LEFT JOIN Submission
                ON Assignment.assignment_id = Submission.assign_id
                AND Submission.student_id = Enrollment.student_id
            WHERE Enrollment.student_id = :student_id
                AND Enrollment.status = "Enrolled"
            ORDER BY Assignment.deadline ASC, Assignment.created_at DESC
        ', ['student_id' => $student['student_id']])->get();

    $quizzes = array_values(array_filter($assignments, function ($assignment) {
        return $assignment['assignment_type'] === 'Quiz';
    }));

    $classAssignments = array_values(array_filter($assignments, function ($assignment) {
        return $assignment['assignment_type'] === 'Assignment';
    }));

    $pendingQuizCount = count(array_filter($quizzes, function ($assignment) {
        return $assignment['student_status'] === 'Pending';
    }));

    $pendingAssignmentCount = count(array_filter($classAssignments, function ($assignment) {
        return $assignment['student_status'] === 'Pending';
    }));

    return view('classrooms', [
        'role' => $role,
        'student' => $student,
        'courses' => $courses,
        'availableCourses' => $availableCourses,
        'assignments' => $assignments,
        'quizzes' => $quizzes,
        'classAssignments' => $classAssignments,
        'pendingQuizCount' => $pendingQuizCount,
        'pendingAssignmentCount' => $pendingAssignmentCount,
    ]);
}

if (in_array($role, ['Professor', 'Dumbledore'], true)) {
    $dashboard = new DashboardModel();
    $classroomData = $dashboard->overviewForCurrentUser();
    $professorId = $classroomData['currentProfessor']['professor_id'] ?? null;
    $db = App::resolve('Core\Database');

    $courseStudentWhere = '';
    $courseStudentParams = [];

    if ($professorId) {
        $courseStudentWhere = 'AND Course.professor_id = :professor_id';
        $courseStudentParams['professor_id'] = $professorId;
    }

    $courseStudents = $db->query('SELECT
            Course.course_id,
            Course.course_name,
            Professor.professor_name,
            Student.student_id,
            User.user_name,
            User.email,
            House.house_name,
            Student.status,
            Enrollment.enrolled_at
            FROM Enrollment
            JOIN Course ON Enrollment.course_id = Course.course_id
            JOIN Professor ON Course.professor_id = Professor.professor_id
            JOIN Student ON Enrollment.student_id = Student.student_id
            JOIN User ON Student.user_id = User.user_id
            JOIN House ON Student.house_id = House.house_id
            WHERE Enrollment.status = "Enrolled"
            ' . $courseStudentWhere . '
            ORDER BY Course.course_name, User.user_name
        ', $courseStudentParams)->get();

    return view('classrooms', array_merge(
        [
            'role' => $role,
            'courseStudents' => $courseStudents,
        ],
        $classroomData
    ));
}

abort(403);
