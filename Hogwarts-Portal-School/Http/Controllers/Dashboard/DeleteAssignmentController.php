<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignmentQuery = 'SELECT
        Assignment.assignment_id,
        Assignment.title,
        Assignment.assignment_type,
        Course.course_name,
        COUNT(Submission.submission_id) AS submissions_count
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
        WHERE Assignment.assignment_id = :id';
$assignmentParams = ['id' => $assignment_id];

if (!$isSuperAdmin) {
    $assignmentQuery .= ' AND Course.professor_id = :professor_id';
    $assignmentParams['professor_id'] = $professor['professor_id'];
}

$assignmentQuery .= ' GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type, Course.course_name';
$assignment = $db->query($assignmentQuery, $assignmentParams)->find();

if (!$assignment) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->connection->beginTransaction();

    try {
        $db->query('DELETE hp FROM HousePoints hp
                JOIN Submission s ON hp.submission_id = s.submission_id
                WHERE s.assign_id = :id
            ', [
            'id' => $assignment_id,
        ]);

        $db->query('DELETE FROM Assignment WHERE assignment_id = :id', [
            'id' => $assignment_id,
        ]);

        $db->connection->commit();
    } catch (Throwable $exception) {
        $db->connection->rollBack();
        throw $exception;
    }

    $redirectTo = $assignment['assignment_type'] === 'Quiz' ? '/classrooms#quizzes' : '/classrooms#assignments';
    redirect($redirectTo);
}

return view('Dashboard/delete-assignment', [
    'assignment' => $assignment,
]);
