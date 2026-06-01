<?php
namespace Http\Models;

use Core\Database;
use Core\App;

class CourseModel
{
    private $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getAvailableCourses($studentId)
    {
        return $this->db->query('
            SELECT Course.course_id, Course.course_name, Professor.professor_name 
            FROM Course
            JOIN Professor ON Course.professor_id = Professor.professor_id
            WHERE Course.course_id NOT IN (
                SELECT course_id FROM Enrollment WHERE student_id = :student_id AND status = "Enrolled"
            )
            ORDER BY Course.course_name ASC
        ', ['student_id' => $studentId])->get();
    }

    public function getEnrolledCourses($studentId)
    {
        return $this->db->query('
            SELECT Course.course_id, Course.course_name, Professor.professor_name, Enrollment.enrolled_at 
            FROM Enrollment
            JOIN Course ON Enrollment.course_id = Course.course_id
            JOIN Professor ON Course.professor_id = Professor.professor_id
            WHERE Enrollment.student_id = :student_id AND Enrollment.status = "Enrolled"
            ORDER BY Enrollment.enrolled_at DESC
        ', ['student_id' => $studentId])->get();
    }

    public function enrollStudent($studentId, $courseId)
    {
        $this->db->query('
            INSERT INTO Enrollment (student_id, course_id, status)
            VALUES (:student_id, :course_id, "Enrolled")
            ON DUPLICATE KEY UPDATE status = "Enrolled", enrolled_at = CURRENT_TIMESTAMP
        ', [
            'student_id' => $studentId,
            'course_id' => $courseId
        ]);
    }
}