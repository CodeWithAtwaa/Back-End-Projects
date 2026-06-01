<?php
namespace Http\Models;

use Core\Database;
use Core\App;

class QuizModel
{
    private $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getPendingAssignments($studentId)
    {
        return $this->db->query('
            SELECT Assignment.*, Course.course_name
            FROM Assignment
            JOIN Enrollment ON Assignment.course_id = Enrollment.course_id
            JOIN Course ON Assignment.course_id = Course.course_id
            WHERE Enrollment.student_id = :student_id 
              AND Enrollment.status = "Enrolled"
              AND Assignment.assignment_id NOT IN (
                  SELECT assign_id FROM Submission WHERE student_id = :student_id
              )
            ORDER BY Assignment.deadline ASC
        ', ['student_id' => $studentId])->get();
    }

    public function getAssignmentById($assignmentId, $studentId)
    {
        return $this->db->query('
            SELECT Assignment.*, Course.course_name 
            FROM Assignment
            JOIN Enrollment ON Assignment.course_id = Enrollment.course_id
            JOIN Course ON Assignment.course_id = Course.course_id
            WHERE Assignment.assignment_id = :assignment_id 
              AND Enrollment.student_id = :student_id
              AND Enrollment.status = "Enrolled"
        ', [
            'assignment_id' => $assignmentId,
            'student_id' => $studentId
        ])->find();
    }
}