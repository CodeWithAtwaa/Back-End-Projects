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
    User.user_id,
    User.user_name, 
    User.email AS user_email,
    User.role,
    House.house_name AS house,
    Student.house_id,
    Student.balance,
    Student.status,
    Wand.wood_type,
    Wand.core_type,
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

$houses = $db->query('SELECT house_id, house_name FROM House')->get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $balance = (float) ($_POST['balance'] ?? 0);
    $house_id = $_POST['house_id'] ?? '';
    $status = $_POST['status'] ?? '';
    $wood_type = $_POST['wood_type'] ?? '';
    $core_type = $_POST['core_type'] ?? '';

    $validWoods = ['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'];
    $validCores = ['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'];

    if (
        $user_name &&
        filter_var($email, FILTER_VALIDATE_EMAIL) &&
        $balance >= 0 &&
        $house_id &&
        in_array($status, ['Active', 'Inactive'], true) &&
        in_array($wood_type, $validWoods, true) &&
        in_array($core_type, $validCores, true)
    ) {
        $existing = $db->query('SELECT user_id FROM User WHERE email = :email AND user_id <> :user_id', [
            'email' => $email,
            'user_id' => $student['user_id'],
        ])->find();

        if ($existing) {
            redirect('/edit-student?id=' . $student_id);
        }

        $db->query('UPDATE User SET user_name = :name, email = :email WHERE user_id = :user_id', [
            'name' => $user_name,
            'email' => $email,
            'user_id' => $student['user_id']
        ]);

        $db->query('UPDATE Student SET balance = :balance, house_id = :house_id, status = :status WHERE student_id = :id', [
            'balance' => $balance,
            'house_id' => $house_id,
            'status' => $status,
            'id' => $student_id
        ]);

        $db->query('INSERT INTO Wand (student_id, wood_type, core_type)
                VALUES (:student_id, :wood_type, :core_type)
                ON DUPLICATE KEY UPDATE wood_type = VALUES(wood_type), core_type = VALUES(core_type)
            ', [
            'student_id' => $student_id,
            'wood_type' => $wood_type,
            'core_type' => $core_type,
        ]);

        redirect('/classrooms#students');
    }
}

return view('Dashboard/edit-student', [
    'student' => $student,
    'houses' => $houses,
]);
