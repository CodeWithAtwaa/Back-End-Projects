<?php
use Http\Models\CourseModel;
use Http\Models\QuizModel;
use Core\Session;

$studentId = $_SESSION['user']['student_id'] ?? null;
if (!$studentId) abort(403);

$courseModel = new CourseModel();
$quizModel = new QuizModel();

$myCourses = $courseModel->getEnrolledCourses($studentId);
$pendingWork = $quizModel->getPendingAssignments($studentId);

view('student/myClassrooms', [
    'courses' => $myCourses,
    'assignments' => $pendingWork,
    'success' => Session::get('success')
]);