<?php

use Core\App;
use Core\Session;

$db = App::resolve('Core\Database');

$email = Session::get('user')['email'] ?? null;

if (!$email) {
    redirect('/');
}

$student = $db->query('SELECT
        Student.student_id
        FROM Student
        JOIN User ON Student.user_id = User.user_id
        WHERE User.email = :email AND User.role = "Student"
        ', ['email' => $email])->find();

if (!$student) {
    abort(403);
}

$courseId = $_POST['course_id'] ?? null;

if (!$courseId) {
    redirect('/student-panel#courses');
}

$course = $db->query('SELECT course_id FROM Course WHERE course_id = :course_id', [
    'course_id' => $courseId,
])->find();

if (!$course) {
    redirect('/student-panel#courses');
}

$db->query('INSERT INTO Enrollment (student_id, course_id, status)
        VALUES (:student_id, :course_id, "Enrolled")
        ON DUPLICATE KEY UPDATE status = "Enrolled", enrolled_at = CURRENT_TIMESTAMP
    ', [
    'student_id' => $student['student_id'],
    'course_id' => $courseId,
]);

redirect('/student-panel#courses');
