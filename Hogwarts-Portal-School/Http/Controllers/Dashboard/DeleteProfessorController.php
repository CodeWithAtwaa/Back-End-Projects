<?php

use Core\App;

$db = App::resolve('Core\Database');

authorize(is_dumbledore());

$professor_id = $_GET['id'] ?? null;

if (!$professor_id) {
    abort(400);
}

$professor = $db->query('SELECT
        Professor.professor_id,
        Professor.user_id,
        Professor.professor_name,
        User.email,
        COUNT(Course.course_id) AS courses_count
        FROM Professor
        JOIN User ON Professor.user_id = User.user_id
        LEFT JOIN Course ON Professor.professor_id = Course.professor_id
        WHERE Professor.professor_id = :id
        GROUP BY Professor.professor_id, Professor.user_id, Professor.professor_name, User.email
        ', ['id' => $professor_id])->find();

if (!$professor) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ((int) $professor['courses_count'] > 0) {
        redirect('/delete-professor?id=' . $professor_id);
    }

    $db->query('DELETE FROM User WHERE user_id = :user_id', [
        'user_id' => $professor['user_id'],
    ]);

    redirect('/dashboard');
}

return view('Dashboard/delete-professor', [
    'professor' => $professor,
]);
