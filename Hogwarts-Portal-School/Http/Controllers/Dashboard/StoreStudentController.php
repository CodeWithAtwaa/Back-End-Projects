<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/classrooms#students';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isSuperAdmin = is_dumbledore();
    $professor = null;

    if (!$isSuperAdmin) {
        $professor = require_current_professor($db);
    }

    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $house_name = trim($_POST['house'] ?? '');
    $course_id = $_POST['course_id'] ?? '';
    $balance = (float) ($_POST['balance'] ?? 1000.00);
    $wood_type = $_POST['wood_type'] ?? '';
    $core_type = $_POST['core_type'] ?? '';

    // Validate input
    $validWoods = ['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'];
    $validCores = ['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'];

    if (
        !$user_name ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !$password ||
        (!$isSuperAdmin && !$course_id) ||
        $balance < 0
    ) {
        redirect($redirectTo);
    }

    if (!in_array($wood_type, $validWoods, true)) {
        $wood_type = $validWoods[array_rand($validWoods)];
    }

    if (!in_array($core_type, $validCores, true)) {
        $core_type = $validCores[array_rand($validCores)];
    }

    // Get house ID (randomize when empty or invalid)
    $house = null;
    if ($house_name) {
        $house = $db->query('SELECT house_id FROM House WHERE house_name = :name', ['name' => $house_name])->find();
    }

    if (!$house) {
        $house = $db->query('SELECT house_id FROM House ORDER BY RAND() LIMIT 1')->find();
    }

    if (!$house) {
        redirect($redirectTo);
    }

    $course = null;
    if ($course_id) {
        if ($isSuperAdmin) {
            $course = $db->query('SELECT course_id FROM Course
                    WHERE course_id = :course_id
                ', [
                'course_id' => $course_id,
            ])->find();
        } else {
            $course = $db->query('SELECT course_id FROM Course
                    WHERE course_id = :course_id AND professor_id = :professor_id
                ', [
                'course_id' => $course_id,
                'professor_id' => $professor['professor_id'],
            ])->find();
        }

        if (!$course) {
            redirect($redirectTo);
        }
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
                'role' => 'Student'
            ]
        );

        $user_id = $db->connection->lastInsertId();

        // Insert Student
        $db->query(
            'INSERT INTO Student (user_id, house_id, balance, status) VALUES (:user_id, :house_id, :balance, :status)',
            [
                'user_id' => $user_id,
                'house_id' => $house['house_id'],
                'balance' => $balance,
                'status' => 'Active'
            ]
        );

        $student_id = $db->connection->lastInsertId();

        // Insert Wand
        $db->query(
            'INSERT INTO Wand (student_id, wood_type, core_type) VALUES (:student_id, :wood_type, :core_type)',
            [
                'student_id' => $student_id,
                'wood_type' => $wood_type,
                'core_type' => $core_type
            ]
        );

        if ($course_id) {
            $db->query(
                'INSERT INTO Enrollment (student_id, course_id, status)
                    VALUES (:student_id, :course_id, "Enrolled")',
                [
                    'student_id' => $student_id,
                    'course_id' => $course_id,
                ]
            );
        }

        $db->connection->commit();
    } catch (Throwable $exception) {
        $db->connection->rollBack();
        throw $exception;
    }

    redirect($redirectTo);
}
