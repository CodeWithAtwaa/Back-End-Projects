<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$submissionId = $_POST['submission_id'] ?? null;
$assignmentId = $_POST['assignment_id'] ?? null;

if (!$submissionId || !$assignmentId) {
    redirect('/show-assignment?id=' . $assignmentId);
}

$submissionQuery = 'SELECT Submission.submission_id FROM Submission
        JOIN Assignment ON Submission.assign_id = Assignment.assignment_id
        JOIN Course ON Assignment.course_id = Course.course_id
        WHERE Submission.submission_id = :submission_id
            AND Submission.assign_id = :assignment_id';
$submissionParams = [
    'submission_id' => $submissionId,
    'assignment_id' => $assignmentId,
];

if (!$isSuperAdmin) {
    $submissionQuery .= ' AND Course.professor_id = :professor_id';
    $submissionParams['professor_id'] = $professor['professor_id'];
}

$submission = $db->query($submissionQuery, $submissionParams)->find();

if (!$submission) {
    abort(404);
}

$db->query('DELETE FROM HousePoints WHERE submission_id = :submission_id', [
    'submission_id' => $submissionId,
]);

$db->query('DELETE FROM Submission WHERE submission_id = :submission_id', [
    'submission_id' => $submissionId,
]);

redirect('/show-assignment?id=' . $assignmentId);
