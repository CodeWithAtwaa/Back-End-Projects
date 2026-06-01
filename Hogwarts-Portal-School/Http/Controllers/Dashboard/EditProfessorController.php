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
        User.user_name,
        User.email
        FROM Professor
        JOIN User ON Professor.user_id = User.user_id
        WHERE Professor.professor_id = :id
        ', ['id' => $professor_id])->find();

if (!$professor) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $professor_name = trim($_POST['professor_name'] ?? '');

    if (!$user_name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$professor_name) {
        redirect('/edit-professor?id=' . $professor_id);
    }

    $existing = $db->query('SELECT user_id FROM User WHERE email = :email AND user_id <> :user_id', [
        'email' => $email,
        'user_id' => $professor['user_id'],
    ])->find();

    if ($existing) {
        redirect('/edit-professor?id=' . $professor_id);
    }

    $db->query('UPDATE User SET user_name = :user_name, email = :email WHERE user_id = :user_id', [
        'user_name' => $user_name,
        'email' => $email,
        'user_id' => $professor['user_id'],
    ]);

    $db->query('UPDATE Professor SET professor_name = :professor_name WHERE professor_id = :professor_id', [
        'professor_name' => $professor_name,
        'professor_id' => $professor_id,
    ]);

    redirect('/show-professor?id=' . $professor_id);
}

return view('Dashboard/edit-professor', [
    'professor' => $professor,
]);
