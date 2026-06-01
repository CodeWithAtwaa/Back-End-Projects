<?php
use Http\Models\CourseModel;
use Core\Session;

$studentId = $_SESSION['user']['student_id'] ?? null;
$courseId = $_POST['course_id'] ?? null;

if (!$studentId || !$courseId) {
    redirect('/course-catalog');
}

$courseModel = new CourseModel();
$courseModel->enrollStudent($studentId, $courseId);

$redirectTo = $_SERVER['HTTP_REFERER'] ?? '/my-classrooms';
$refererPath = parse_url($redirectTo, PHP_URL_PATH);
if ($refererPath === '/student-panel') {
    $redirectTo = '/student-panel#courses';
}

Session::flash('success', 'Successfully enrolled in the course!');
redirect($redirectTo);