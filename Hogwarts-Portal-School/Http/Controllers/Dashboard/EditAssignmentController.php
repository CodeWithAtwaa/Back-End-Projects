<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignmentQuery = 'SELECT
        Assignment.assignment_id,
        Assignment.course_id,
        Assignment.assignment_type,
        Assignment.title,
        Assignment.max_points,
        Assignment.deadline
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        WHERE Assignment.assignment_id = :id';
$assignmentParams = ['id' => $assignment_id];

if (!$isSuperAdmin) {
    $assignmentQuery .= ' AND Course.professor_id = :professor_id';
    $assignmentParams['professor_id'] = $professor['professor_id'];
}

$assignment = $db->query($assignmentQuery, $assignmentParams)->find();

if (!$assignment) {
    abort(404);
}

if ($isSuperAdmin) {
    $courses = $db->query('SELECT course_id, course_name
            FROM Course
            ORDER BY course_name
        ')->get();
} else {
    $courses = $db->query('SELECT course_id, course_name
            FROM Course
            WHERE professor_id = :professor_id
            ORDER BY course_name
        ', ['professor_id' => $professor['professor_id']])->get();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $course_id = $_POST['course_id'] ?? '';
    $assignment_type = $_POST['assignment_type'] ?? '';
    $max_points = (int) ($_POST['max_points'] ?? 100);
    $deadline = $_POST['deadline'] ?? '';

    if (!$title || !$course_id || !in_array($assignment_type, ['Quiz', 'Assignment'], true) || !$deadline || $max_points < 1) {
        redirect('/edit-assignment?id=' . $assignment_id);
    }

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
        redirect('/edit-assignment?id=' . $assignment_id);
    }

    $deadline = str_replace('T', ' ', $deadline);
    if (strlen($deadline) === 16) {
        $deadline .= ':00';
    }

    $db->query('UPDATE Assignment
            SET course_id = :course_id,
                assignment_type = :assignment_type,
                title = :title,
                max_points = :max_points,
                deadline = :deadline
            WHERE assignment_id = :assignment_id
        ', [
        'course_id' => $course_id,
        'assignment_type' => $assignment_type,
        'title' => $title,
        'max_points' => $max_points,
        'deadline' => $deadline,
        'assignment_id' => $assignment_id,
    ]);

    redirect('/show-assignment?id=' . $assignment_id);
}

return view('Dashboard/edit-assignment', [
    'assignment' => $assignment,
    'courses' => $courses,
]);
