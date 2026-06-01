<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    abort(400);
}

$courseQuery = 'SELECT course_id, course_name, professor_id
        FROM Course
        WHERE course_id = :id';
$courseParams = ['id' => $course_id];

if (!$isSuperAdmin) {
    $courseQuery .= ' AND professor_id = :professor_id';
    $courseParams['professor_id'] = $professor['professor_id'];
}

$course = $db->query($courseQuery, $courseParams)->find();

if (!$course) {
    abort(404);
}

if ($isSuperAdmin) {
    $professors = $db->query('SELECT professor_id, professor_name FROM Professor ORDER BY professor_name')->get();
} else {
    $professors = [$professor];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $professor_id = $isSuperAdmin ? ($_POST['professor_id'] ?? '') : $professor['professor_id'];

    if (!$course_name || !$professor_id) {
        redirect('/edit-course?id=' . $course_id);
    }

    if ($isSuperAdmin) {
        $professorRecord = $db->query('SELECT professor_id FROM Professor WHERE professor_id = :professor_id', [
            'professor_id' => $professor_id,
        ])->find();

        if (!$professorRecord) {
            redirect('/edit-course?id=' . $course_id);
        }
    }

    $db->query('UPDATE Course SET course_name = :course_name, professor_id = :professor_id WHERE course_id = :course_id', [
        'course_name' => $course_name,
        'professor_id' => $professor_id,
        'course_id' => $course_id,
    ]);

    redirect('/show-course?id=' . $course_id);
}

return view('Dashboard/edit-course', [
    'course' => $course,
    'professors' => $professors,
]);
