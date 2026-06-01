<?php

$dsn = "mysql:host=localhost;dbname=todos;charset=utf8";
$user = "root";
$password = "";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $connect = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
