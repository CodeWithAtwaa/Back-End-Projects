<?php
use Http\Models\SubmissionModel;
use Http\Models\QuizModel;
use Core\Session;

$studentId = $_SESSION['user']['student_id'] ?? null;
$houseId = $_SESSION['user']['house_id'] ?? null;
$assignmentId = $_POST['assignment_id'] ?? null;

if (!$studentId || !$assignmentId) {
    redirect('/my-classrooms');
}

$quizModel = new QuizModel();
$assignment = $quizModel->getAssignmentById($assignmentId, $studentId);

if (!$assignment) {
    redirect('/my-classrooms');
}

if (strtotime($assignment['deadline']) < time()) {
    redirect('/my-classrooms');
}

$submissionModel = new SubmissionModel();
if ($submissionModel->hasSubmission($assignmentId, $studentId)) {
    Session::flash('success', 'Quiz already submitted.');
    redirect('/my-classrooms');
}

// Since there's no Questions table in the schema, we'll simulate grading
// Give a random score between 70% and 100% of the max points
$maxPoints = (int) $assignment['max_points'];
$score = rand((int)($maxPoints * 0.7), $maxPoints);

$submissionModel->saveScore($assignmentId, $studentId, $score, $houseId);

Session::flash('success', "Quiz submitted! You earned $score points for your House.");

redirect('/my-classrooms');