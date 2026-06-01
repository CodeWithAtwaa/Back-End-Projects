<?php

use Core\Response;
use Core\Session;

function dd($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

function active($path) {
    return $_SERVER['REQUEST_URI'] === $path ? 'bg-gray-900 text-white' : '';
}

function abort($code = 404) {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
function authorize($condition, $status = Response::FORBIDDEN) {
    if (! $condition)
        abort($status);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function user_role() {
    return current_user()['role'] ?? null;
}

function is_student() {
    return user_role() === 'Student';
}

function is_professor() {
    return user_role() === 'Professor';
}

function is_dumbledore() {
    return user_role() === 'Dumbledore';
}

function is_staff() {
    return in_array(user_role(), ['Dumbledore', 'Professor'], true);
}

function current_professor($db) {
    if (!is_professor()) {
        return null;
    }

    return $db->query('SELECT professor_id, professor_name
            FROM Professor
            WHERE user_id = :user_id
        ', [
        'user_id' => current_user()['user_id'] ?? null,
    ])->find();
}

function require_current_professor($db) {
    $professor = current_professor($db);

    if (!$professor) {
        abort(403);
    }

    return $professor;
}

function professor_owns_student($db, $studentId, $professorId = null) {
    if (!$professorId) {
        $professorId = require_current_professor($db)['professor_id'];
    }

    return (bool) $db->query('SELECT Student.student_id
            FROM Student
            JOIN Enrollment ON Student.student_id = Enrollment.student_id
            JOIN Course ON Enrollment.course_id = Course.course_id
            WHERE Student.student_id = :student_id
                AND Course.professor_id = :professor_id
                AND Enrollment.status = "Enrolled"
            LIMIT 1
        ', [
        'student_id' => $studentId,
        'professor_id' => $professorId,
    ])->find();
}

function professor_owns_course($db, $courseId, $professorId = null) {
    if (!$professorId) {
        $professorId = require_current_professor($db)['professor_id'];
    }

    return (bool) $db->query('SELECT course_id
            FROM Course
            WHERE course_id = :course_id
                AND professor_id = :professor_id
            LIMIT 1
        ', [
        'course_id' => $courseId,
        'professor_id' => $professorId,
    ])->find();
}

function professor_owns_assignment($db, $assignmentId, $professorId = null) {
    if (!$professorId) {
        $professorId = require_current_professor($db)['professor_id'];
    }

    return (bool) $db->query('SELECT Assignment.assignment_id
            FROM Assignment
            JOIN Course ON Assignment.course_id = Course.course_id
            WHERE Assignment.assignment_id = :assignment_id
                AND Course.professor_id = :professor_id
            LIMIT 1
        ', [
        'assignment_id' => $assignmentId,
        'professor_id' => $professorId,
    ])->find();
}

function base_path($path) {
    return BASE_PATH . $path;
}

function view($path, $attributes = []) {
    extract($attributes);
    require base_path('views/' . $path . '.view.php');
}

function redirect($path) {
    header("Location: {$path}");
    exit();
}

function old($key, $default = ''){
    return Session::get('old')[$key]?? $default;
}
