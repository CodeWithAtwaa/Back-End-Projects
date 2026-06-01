<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/classrooms#courses';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $isSuperAdmin = is_dumbledore();
    $professor = null;
    $professor_id = null;

    if ($isSuperAdmin) {
        $professor_id = $_POST['professor_id'] ?? '';
    } else {
        $professor = require_current_professor($db);
        $professor_id = $professor['professor_id'];
    }

    // Validate input
    if (!$course_name || !$professor_id) {
        redirect($redirectTo);
    }

    if ($isSuperAdmin) {
        $professorRecord = $db->query('SELECT professor_id FROM Professor WHERE professor_id = :professor_id', [
            'professor_id' => $professor_id,
        ])->find();

        if (!$professorRecord) {
            redirect($redirectTo);
        }
    }

    // Insert Course
    $db->query(
        'INSERT INTO Course (course_name, professor_id) VALUES (:name, :professor_id)',
        [
            'name' => $course_name,
            'professor_id' => $professor_id
        ]
    );

    redirect($redirectTo);
}
