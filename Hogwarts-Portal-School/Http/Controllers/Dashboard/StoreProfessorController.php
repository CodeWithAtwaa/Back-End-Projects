<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/dashboard#professors';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $professor_name = trim($_POST['professor_name'] ?? '');

    // Validate input
    if (!$user_name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$password || !$professor_name) {
        redirect($redirectTo);
    }

    // Check if email already exists
    $existing = $db->query('SELECT user_id FROM User WHERE email = :email', ['email' => $email])->find();
    if ($existing) {
        redirect($redirectTo);
    }

    $db->connection->beginTransaction();

    try {
        // Insert User
        $db->query(
            'INSERT INTO User (user_name, email, password, role) VALUES (:name, :email, :password, :role)',
            [
                'name' => $user_name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role' => 'Professor'
            ]
        );

        $user_id = $db->connection->lastInsertId();

        // Insert Professor
        $db->query(
            'INSERT INTO Professor (user_id, professor_name) VALUES (:user_id, :professor_name)',
            [
                'user_id' => $user_id,
                'professor_name' => $professor_name
            ]
        );

        $db->connection->commit();
    } catch (Throwable $exception) {
        $db->connection->rollBack();
        throw $exception;
    }

    redirect($redirectTo);
}
