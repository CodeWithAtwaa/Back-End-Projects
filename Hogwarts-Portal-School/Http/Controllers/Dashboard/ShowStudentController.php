<?php

use Core\App;

$db = App::resolve('Core\Database');

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    abort(400);
}

$student = $db->query('SELECT 
    Student.student_id, 
    User.user_name, 
    User.email AS user_email,
    User.role,
    House.house_name AS house,
    Student.balance,
    Student.status,
    CONCAT(Wand.wood_type, " - " , Wand.core_type) AS wand  
            FROM Student
            JOIN User ON Student.user_id = User.user_id
            JOIN House ON Student.house_id = House.house_id
            LEFT JOIN Wand ON Student.student_id = Wand.student_id
            WHERE Student.student_id = :id
        ', ['id' => $student_id])->find();

if (!$student) {
    abort(404);
}

return view('Dashboard/show-student', [
    'student' => $student,
]);
