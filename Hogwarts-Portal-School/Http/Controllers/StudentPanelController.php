<?php

use Core\App;
use Core\Session;

$db = App::resolve('Core\Database');

$email = Session::get('user')['email'] ?? null;

if (!$email) {
    redirect('/');
}

$student = $db->query('SELECT
        Student.student_id,
        Student.balance,
        Student.status,
        User.user_id,
        User.user_name,
        User.email,
        House.house_name,
        House.total_points,
        CONCAT(Wand.wood_type, " - ", Wand.core_type) AS wand
        FROM Student
        JOIN User ON Student.user_id = User.user_id
        JOIN House ON Student.house_id = House.house_id
        LEFT JOIN Wand ON Student.student_id = Wand.student_id
        WHERE User.email = :email AND User.role = "Student"
        ', ['email' => $email])->find();

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

$submittedAssignments = array_filter($assignments, function ($assignment) {
    return $assignment['submission_id'] !== null;
});

$pendingAssignments = array_filter($assignments, function ($assignment) {
    return $assignment['student_status'] === 'Pending';
});

$overdueAssignments = array_filter($assignments, function ($assignment) {
    return $assignment['student_status'] === 'Overdue';
});

$earnedPoints = array_sum(array_map(function ($assignment) {
    return (int) ($assignment['score'] ?? 0);
}, $submittedAssignments));

$possibleSubmittedPoints = array_sum(array_map(function ($assignment) {
    return (int) $assignment['max_points'];
}, $submittedAssignments));

$stats = [
    'courses' => count(array_filter($courses, function ($course) {
        return $course['status'] === 'Enrolled';
    })),
    'assignments' => count($assignments),
    'quizzes' => count($quizzes),
    'class_assignments' => count($classAssignments),
    'submitted' => count($submittedAssignments),
    'pending' => count($pendingAssignments),
    'overdue' => count($overdueAssignments),
    'average_score' => $possibleSubmittedPoints > 0 ? round(($earnedPoints / $possibleSubmittedPoints) * 100) : 0,
];

return view('student-panel', [
    'student' => $student,
    'courses' => $courses,
    'availableCourses' => $availableCourses,
    'assignments' => $assignments,
    'quizzes' => $quizzes,
    'classAssignments' => $classAssignments,
    'pendingAssignments' => $pendingAssignments,
    'submittedAssignments' => $submittedAssignments,
    'overdueAssignments' => $overdueAssignments,
    'stats' => $stats,
]);
