<?php
use Http\Models\CourseModel;
use Core\Session;

$studentId = $_SESSION['user']['student_id'] ?? null;
if (!$studentId) abort(403);

$courseModel = new CourseModel();
$availableCourses = $courseModel->getAvailableCourses($studentId);

view('student/courseCatalog', [
    'courses' => $availableCourses,
    'success' => Session::get('success')
]);