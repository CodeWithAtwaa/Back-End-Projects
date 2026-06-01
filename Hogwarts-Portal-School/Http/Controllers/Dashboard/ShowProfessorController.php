<?php

use Core\App;

$db = App::resolve('Core\Database');

$professor_id = $_GET['id'] ?? null;

if (!$professor_id) {
    abort(400);
}

if (is_professor()) {
    $currentProfessor = require_current_professor($db);
    authorize((int) $professor_id === (int) $currentProfessor['professor_id']);
}

$professor = $db->query('SELECT 
        Professor.professor_id,
        User.user_id,
        User.user_name,
        User.email,
        Professor.professor_name,
        COUNT(DISTINCT Course.course_id) AS courses_count,
        COUNT(DISTINCT Enrollment.student_id) AS students_count
        FROM Professor
        JOIN User ON Professor.user_id = User.user_id
        LEFT JOIN Course ON Professor.professor_id = Course.professor_id
        LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
        WHERE Professor.professor_id = :id
        GROUP BY Professor.professor_id, User.user_id, User.user_name, User.email, Professor.professor_name
        ', ['id' => $professor_id])->find();

if (!$professor) {
    abort(404);
}

$courses = $db->query('SELECT course_id, course_name FROM Course WHERE professor_id = :id', 
    ['id' => $professor_id])->get();

return view('Dashboard/show-professor', [
    'professor' => $professor,
    'courses' => $courses,
]);
