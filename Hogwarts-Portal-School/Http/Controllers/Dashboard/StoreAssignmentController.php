<?php

use Core\App;

$db = App::resolve('Core\Database');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isSuperAdmin = is_dumbledore();
    $professor = null;

    if (!$isSuperAdmin) {
        $professor = require_current_professor($db);
    }

    $title = trim($_POST['title'] ?? '');
    $course_id = $_POST['course_id'] ?? '';
    $assignment_type = $_POST['assignment_type'] ?? '';
    $max_points = (int) ($_POST['max_points'] ?? 100);
    $deadline = $_POST['deadline'] ?? '';
    $validTypes = ['Quiz', 'Assignment'];
    $redirectTo = $assignment_type === 'Quiz' ? '/classrooms#quizzes' : '/classrooms#assignments';

    // Validate input
    if (!$title || !$course_id || !in_array($assignment_type, $validTypes, true) || !$deadline || $max_points < 1) {
        redirect($redirectTo);
    }

    $deadline = str_replace('T', ' ', $deadline);
    if (strlen($deadline) === 16) {
        $deadline .= ':00';
    }

    // Verify course exists
    if ($isSuperAdmin) {
        $course = $db->query('SELECT course_id FROM Course
                WHERE course_id = :id
            ', [
            'id' => $course_id,
        ])->find();
    } else {
        $course = $db->query('SELECT course_id FROM Course
                WHERE course_id = :id AND professor_id = :professor_id
            ', [
            'id' => $course_id,
            'professor_id' => $professor['professor_id'],
        ])->find();
    }
    if (!$course) {
        redirect($redirectTo);
    }

    // Insert Assignment
    $db->query(
        'INSERT INTO Assignment (course_id, assignment_type, title, max_points, deadline) 
         VALUES (:course_id, :type, :title, :max_points, :deadline)',
        [
            'course_id' => $course_id,
            'type' => $assignment_type,
            'title' => $title,
            'max_points' => $max_points,
            'deadline' => $deadline
        ]
    );

    redirect($redirectTo);
}
