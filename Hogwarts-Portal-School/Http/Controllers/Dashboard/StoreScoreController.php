<?php

use Core\App;

$db = App::resolve('Core\Database');
$isSuperAdmin = is_dumbledore();
$professor = null;

if (!$isSuperAdmin) {
    $professor = require_current_professor($db);
}

$assignmentId = $_POST['assignment_id'] ?? null;
$studentId = $_POST['student_id'] ?? null;
$score = $_POST['score'] ?? null;

if (!$assignmentId || !$studentId || $score === null || $score === '') {
    redirect('/show-assignment?id=' . $assignmentId);
}

$assignment = $db->query('SELECT
        Assignment.assignment_id,
        Assignment.course_id,
        Assignment.max_points
        , Course.professor_id
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        WHERE Assignment.assignment_id = :assignment_id
        ', ['assignment_id' => $assignmentId])->find();

if (!$assignment || (!$isSuperAdmin && (int) $assignment['professor_id'] !== (int) $professor['professor_id'])) {
    abort(404);
}

$score = (int) $score;

if ($score < 0 || $score > (int) $assignment['max_points']) {
    redirect('/show-assignment?id=' . $assignmentId);
}

$student = $db->query('SELECT
        Student.student_id,
        Student.house_id
        FROM Student
        JOIN Enrollment
            ON Student.student_id = Enrollment.student_id
            AND Enrollment.course_id = :course_id
            AND Enrollment.status = "Enrolled"
        WHERE Student.student_id = :student_id
        ', [
    'course_id' => $assignment['course_id'],
    'student_id' => $studentId,
])->find();

if (!$student) {
    abort(403);
}

$existingSubmission = $db->query('SELECT submission_id FROM Submission
        WHERE assign_id = :assignment_id AND student_id = :student_id
        ', [
    'assignment_id' => $assignmentId,
    'student_id' => $studentId,
])->find();

$db->connection->beginTransaction();

try {
    if ($existingSubmission) {
        $submissionId = $existingSubmission['submission_id'];

        $db->query('DELETE FROM HousePoints WHERE submission_id = :submission_id', [
            'submission_id' => $submissionId,
        ]);

        $db->query('UPDATE Submission SET score = :score WHERE submission_id = :submission_id', [
            'score' => $score,
            'submission_id' => $submissionId,
        ]);
    } else {
        $db->query('INSERT INTO Submission (assign_id, student_id, score)
                VALUES (:assignment_id, :student_id, :score)
            ', [
            'assignment_id' => $assignmentId,
            'student_id' => $studentId,
            'score' => $score,
        ]);

        $submissionId = $db->connection->lastInsertId();
    }

    $db->query('INSERT INTO HousePoints (house_id, student_id, submission_id, points)
            VALUES (:house_id, :student_id, :submission_id, :points)
        ', [
        'house_id' => $student['house_id'],
        'student_id' => $studentId,
        'submission_id' => $submissionId,
        'points' => $score,
    ]);

    $db->connection->commit();
} catch (Throwable $exception) {
    $db->connection->rollBack();
    throw $exception;
}

redirect('/show-assignment?id=' . $assignmentId);
