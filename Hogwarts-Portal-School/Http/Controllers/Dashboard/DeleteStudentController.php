<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    abort(400);
}

if (!$isSuperAdmin) {
    authorize(professor_owns_student($db, $student_id, $professor['professor_id']));
}

$student = $db->query('SELECT
        Student.student_id,
        Student.user_id,
        Student.status,
        User.user_name,
        User.email,
        House.house_name
        FROM Student
        JOIN User ON Student.user_id = User.user_id
        JOIN House ON Student.house_id = House.house_id
        WHERE Student.student_id = :id
        ', ['id' => $student_id])->find();

if (!$student) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->connection->beginTransaction();

    try {
        $db->query('DELETE FROM HousePoints WHERE student_id = :student_id', [
            'student_id' => $student_id,
        ]);

        $db->query('DELETE FROM User WHERE user_id = :user_id', [
            'user_id' => $student['user_id'],
        ]);

        $db->connection->commit();
    } catch (Throwable $exception) {
        $db->connection->rollBack();
        throw $exception;
    }

    redirect('/classrooms#students');
}

return view('Dashboard/delete-student', [
    'student' => $student,
]);
