<?php
namespace Http\Models;

use Core\Database;
use Core\App;

class SubmissionModel
{
    private $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function hasSubmission($assignmentId, $studentId)
    {
        return (bool) $this->db->query('
            SELECT submission_id
            FROM Submission
            WHERE assign_id = :assign_id AND student_id = :student_id
            LIMIT 1
        ', [
            'assign_id' => $assignmentId,
            'student_id' => $studentId
        ])->find();
    }

    public function saveScore($assignmentId, $studentId, $score, $houseId)
    {
        $this->db->connection->beginTransaction();
        try {
            // Insert the submission
            $this->db->query('
                INSERT INTO Submission (assign_id, student_id, score) 
                VALUES (:assign_id, :student_id, :score)
            ', [
                'assign_id' => $assignmentId,
                'student_id' => $studentId,
                'score' => $score
            ]);

            $submissionId = $this->db->connection->lastInsertId();

            // Insert the house points 
            $this->db->query('
                INSERT INTO HousePoints (house_id, student_id, submission_id, points)
                VALUES (:house_id, :student_id, :submission_id, :points)
            ', [
                'house_id' => $houseId,
                'student_id' => $studentId,
                'submission_id' => $submissionId,
                'points' => $score
            ]);

            $this->db->connection->commit();
        } catch (\Exception $e) {
            $this->db->connection->rollBack();
            throw $e;
        }
    }
}