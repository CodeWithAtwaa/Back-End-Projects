<?php

use Core\App;
use Core\Session;

$db = App::resolve('Core\Database');

$assignmentId = $_POST['assignment_id'] ?? null;
$userId = current_user()['user_id'] ?? null;
$redirectTo = $_POST['redirect_to'] ?? '/student-panel#assignments';

if (!is_string($redirectTo) || strpos($redirectTo, '/') !== 0) {
    $redirectTo = '/student-panel#assignments';
}

if (!$assignmentId || !$userId) {
    redirect($redirectTo);
}

$student = $db->query('SELECT student_id, house_id
        FROM Student
        WHERE user_id = :user_id AND status = "Active"
    ', [
    'user_id' => $userId,
])->find();

if (!$student) {
    abort(403);
}

$assignment = $db->query('SELECT
        Assignment.assignment_id,
        Assignment.course_id,
        Assignment.title,
        Assignment.max_points,
        Assignment.deadline
        FROM Assignment
        JOIN Enrollment
            ON Assignment.course_id = Enrollment.course_id
            AND Enrollment.student_id = :student_id
            AND Enrollment.status = "Enrolled"
        WHERE Assignment.assignment_id = :assignment_id
        LIMIT 1
    ', [
    'assignment_id' => $assignmentId,
    'student_id' => $student['student_id'],
])->find();

if (!$assignment) {
    abort(404);
}

$existingSubmission = $db->query('SELECT submission_id
        FROM Submission
        WHERE assign_id = :assignment_id AND student_id = :student_id
        LIMIT 1
    ', [
    'assignment_id' => $assignmentId,
    'student_id' => $student['student_id'],
])->find();

if ($existingSubmission) {
    Session::flash('submission_message', 'This work has already been submitted.');
    redirect($redirectTo);
}

if (strtotime($assignment['deadline']) < time()) {
    Session::flash('submission_message', 'The deadline has passed, so this work can no longer earn house points.');
    redirect($redirectTo);
}

$points = (int) $assignment['max_points'];

$db->connection->beginTransaction();

try {
    $db->query('INSERT INTO Submission (assign_id, student_id, score)
            VALUES (:assignment_id, :student_id, :score)
        ', [
        'assignment_id' => $assignmentId,
        'student_id' => $student['student_id'],
        'score' => $points,
    ]);

    $submissionId = $db->connection->lastInsertId();

    $db->query('INSERT INTO HousePoints (house_id, student_id, submission_id, points)
            VALUES (:house_id, :student_id, :submission_id, :points)
        ', [
        'house_id' => $student['house_id'],
        'student_id' => $student['student_id'],
        'submission_id' => $submissionId,
        'points' => $points,
    ]);

    $db->connection->commit();
} catch (Throwable $exception) {
    $db->connection->rollBack();
    throw $exception;
}

Session::flash('submission_message', 'Submitted on time. ' . $points . ' points were awarded to your house.');
redirect($redirectTo);
