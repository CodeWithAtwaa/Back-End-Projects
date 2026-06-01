<?php

use Core\App;

$db = App::resolve('Core\Database');

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignment = $db->query('SELECT 
        Assignment.assignment_id,
        Assignment.title,
        Assignment.assignment_type,
        Course.course_id,
        Course.course_name,
        Course.professor_id AS course_professor_id,
        Professor.professor_name,
        Assignment.max_points,
        Assignment.deadline,
        Assignment.created_at,
        COUNT(DISTINCT Submission.submission_id) AS submission_count
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        JOIN Professor ON Course.professor_id = Professor.professor_id
        LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
        WHERE Assignment.assignment_id = :id
        GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type, 
                 Course.course_id, Course.course_name, Course.professor_id, Professor.professor_name, 
                 Assignment.max_points, Assignment.deadline, Assignment.created_at
        ', ['id' => $assignment_id])->find();

if (!$assignment) {
    abort(404);
}

if (is_professor()) {
    $professor = require_current_professor($db);

    if ((int) $assignment['course_professor_id'] !== (int) $professor['professor_id']) {
        abort(403);
    }
}

$submissions = $db->query('SELECT
        Student.student_id,
        User.user_name,
        Submission.submission_id,
        Submission.score,
        Submission.submitted_at
        FROM Assignment
        JOIN Enrollment
            ON Assignment.course_id = Enrollment.course_id
            AND Enrollment.status = "Enrolled"
        JOIN Student ON Enrollment.student_id = Student.student_id
        JOIN User ON Student.user_id = User.user_id
        LEFT JOIN Submission
            ON Assignment.assignment_id = Submission.assign_id
            AND Submission.student_id = Student.student_id
        WHERE Assignment.assignment_id = :id
        ORDER BY User.user_name
        ', ['id' => $assignment_id])->get();

return view('Dashboard/show-assignment', [
    'assignment' => $assignment,
    'submissions' => $submissions,
]);
