<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class DashboardModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function overviewForCurrentUser(bool $ignoreProfessorScope = false): array
    {
        $currentProfessor = is_professor() ? $this->currentProfessor() : null;
        $professorId = $ignoreProfessorScope ? null : ($currentProfessor['professor_id'] ?? null);

        return [
            'Students' => $this->students($professorId),
            'Professors' => $this->professors($professorId),
            'Courses' => $this->courses($professorId),
            'Assignments' => $this->assignments($professorId),
            'stats' => $this->stats($professorId),
            'houseStats' => $this->houseStats($professorId),
            'currentProfessor' => $currentProfessor,
        ];
    }

    private function currentProfessor(): array
    {
        $professor = $this->db->query('SELECT professor_id, professor_name
                FROM Professor
                WHERE user_id = :user_id
            ', [
            'user_id' => current_user()['user_id'] ?? null,
        ])->find();

        if (!$professor) {
            abort(403);
        }

        return $professor;
    }

    private function students(?int $professorId): array
    {
        $scopeJoin = '';
        $scopeWhere = '';
        $params = [];

        if ($professorId) {
            $scopeJoin = 'JOIN Enrollment ON Student.student_id = Enrollment.student_id
                JOIN Course ON Enrollment.course_id = Course.course_id';
            $scopeWhere = 'WHERE Course.professor_id = :professor_id
                AND Enrollment.status = "Enrolled"';
            $params['professor_id'] = $professorId;
        }

        return $this->db->query('SELECT DISTINCT
                Student.student_id,
                User.user_name,
                User.email AS user_email,
                House.house_name AS house,
                Student.balance,
                Student.status,
                CONCAT(Wand.wood_type, " - " , Wand.core_type) AS wand
            FROM Student
            JOIN User ON Student.user_id = User.user_id
            JOIN House ON Student.house_id = House.house_id
            LEFT JOIN Wand ON Student.student_id = Wand.student_id
            ' . $scopeJoin . '
            ' . $scopeWhere . '
            ORDER BY Student.student_id DESC
        ', $params)->get();
    }

    private function professors(?int $professorId): array
    {
        $where = '';
        $params = [];

        if ($professorId) {
            $where = 'WHERE Professor.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->db->query('SELECT
                Professor.professor_id,
                User.user_name,
                User.email,
                Professor.professor_name,
                COUNT(DISTINCT Course.course_id) AS courses_count,
                COUNT(DISTINCT Enrollment.student_id) AS students_count
            FROM Professor
            JOIN User ON Professor.user_id = User.user_id
            LEFT JOIN Course ON Professor.professor_id = Course.professor_id
            LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
            ' . $where . '
            GROUP BY Professor.professor_id, User.user_name, User.email, Professor.professor_name
            ORDER BY Professor.professor_id DESC
        ', $params)->get();
    }

    private function courses(?int $professorId): array
    {
        $where = '';
        $params = [];

        if ($professorId) {
            $where = 'WHERE Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->db->query('SELECT
                Course.course_id,
                Course.course_name,
                Professor.professor_name,
                User.user_name AS prof_user_name,
                COUNT(DISTINCT Enrollment.student_id) AS enrolled_count,
                COUNT(DISTINCT Assignment.assignment_id) AS assignments_count,
                COUNT(DISTINCT Submission.submission_id) AS submissions_count
            FROM Course
            JOIN Professor ON Course.professor_id = Professor.professor_id
            JOIN User ON Professor.user_id = User.user_id
            LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
            LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
            LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
            ' . $where . '
            GROUP BY Course.course_id, Course.course_name, Professor.professor_name, User.user_name
            ORDER BY Course.course_id DESC
        ', $params)->get();
    }

    private function assignments(?int $professorId): array
    {
        $where = '';
        $params = [];

        if ($professorId) {
            $where = 'WHERE Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->db->query('SELECT
                Assignment.assignment_id,
                Assignment.title,
                Assignment.assignment_type,
                Course.course_name,
                Professor.professor_name,
                Assignment.max_points,
                Assignment.deadline,
                Assignment.created_at,
                COUNT(DISTINCT Submission.submission_id) AS submission_count
            FROM Assignment
            JOIN Course ON Assignment.course_id = Course.course_id
            JOIN Professor ON Course.professor_id = Professor.professor_id
            LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
            ' . $where . '
            GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type,
                Course.course_name, Professor.professor_name, Assignment.max_points,
                Assignment.deadline, Assignment.created_at
            ORDER BY Assignment.created_at DESC
        ', $params)->get();
    }

    private function stats(?int $professorId): array
    {
        return [
            'total_students' => $this->countStudents($professorId),
            'active_students' => $this->countStudents($professorId, 'Active'),
            'inactive_students' => $this->countStudents($professorId, 'Inactive'),
            'total_professors' => $professorId ? 1 : $this->count('SELECT COUNT(*) AS count FROM Professor'),
            'total_courses' => $this->countCourses($professorId),
            'total_enrollments' => $this->countEnrollments($professorId),
            'total_assignments' => $this->countAssignments($professorId),
            'total_quizzes' => $this->countAssignments($professorId, 'Quiz'),
            'total_class_assignments' => $this->countAssignments($professorId, 'Assignment'),
            'active_quizzes' => $this->countAssignments($professorId, 'Quiz', true),
            'active_class_assignments' => $this->countAssignments($professorId, 'Assignment', true),
            'upcoming_deadlines' => $this->countAssignments($professorId, null, true),
            'total_submissions' => $this->countSubmissions($professorId),
            'points_awarded' => $this->sumHousePoints($professorId),
            'house_points' => $this->sumHouseTotals($professorId),
        ];
    }

    private function houseStats(?int $professorId): array
    {
        $params = [];
        $studentCount = 'COUNT(Student.student_id)';
        $join = 'LEFT JOIN Student ON House.house_id = Student.house_id';

        if ($professorId) {
            $studentCount = 'COUNT(DISTINCT CASE WHEN Course.course_id IS NOT NULL THEN ScopedStudent.student_id END)';
            $join = 'LEFT JOIN Student AS ScopedStudent ON House.house_id = ScopedStudent.house_id
                LEFT JOIN Enrollment ON ScopedStudent.student_id = Enrollment.student_id
                LEFT JOIN Course ON Enrollment.course_id = Course.course_id
                    AND Course.professor_id = :professor_id
                    AND Enrollment.status = "Enrolled"';
            $params['professor_id'] = $professorId;
        }

        return $this->db->query('SELECT
                House.house_name,
                ' . $studentCount . ' AS students_count,
                House.total_points
            FROM House
            ' . $join . '
            GROUP BY House.house_id, House.house_name, House.total_points
            ORDER BY House.house_name
        ', $params)->get();
    }

    private function countStudents(?int $professorId, ?string $status = null): int
    {
        $params = [];
        $joins = '';
        $where = [];

        if ($professorId) {
            $joins = 'JOIN Enrollment ON Student.student_id = Enrollment.student_id
                JOIN Course ON Enrollment.course_id = Course.course_id';
            $where[] = 'Course.professor_id = :professor_id';
            $where[] = 'Enrollment.status = "Enrolled"';
            $params['professor_id'] = $professorId;
        }

        if ($status) {
            $where[] = 'Student.status = :status';
            $params['status'] = $status;
        }

        return $this->count('SELECT COUNT(DISTINCT Student.student_id) AS count
            FROM Student
            ' . $joins . '
            ' . $this->where($where), $params);
    }

    private function countCourses(?int $professorId): int
    {
        $params = [];
        $where = [];

        if ($professorId) {
            $where[] = 'professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->count('SELECT COUNT(*) AS count FROM Course ' . $this->where($where), $params);
    }

    private function countEnrollments(?int $professorId): int
    {
        $params = [];
        $join = '';
        $where = ['Enrollment.status = "Enrolled"'];

        if ($professorId) {
            $join = 'JOIN Course ON Enrollment.course_id = Course.course_id';
            $where[] = 'Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->count('SELECT COUNT(*) AS count
            FROM Enrollment
            ' . $join . '
            ' . $this->where($where), $params);
    }

    private function countAssignments(?int $professorId, ?string $type = null, bool $futureOnly = false): int
    {
        $params = [];
        $join = '';
        $where = [];

        if ($professorId) {
            $join = 'JOIN Course ON Assignment.course_id = Course.course_id';
            $where[] = 'Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        if ($type) {
            $where[] = 'Assignment.assignment_type = :assignment_type';
            $params['assignment_type'] = $type;
        }

        if ($futureOnly) {
            $where[] = 'Assignment.deadline >= NOW()';
        }

        return $this->count('SELECT COUNT(*) AS count
            FROM Assignment
            ' . $join . '
            ' . $this->where($where), $params);
    }

    private function countSubmissions(?int $professorId): int
    {
        $params = [];
        $join = '';
        $where = [];

        if ($professorId) {
            $join = 'JOIN Assignment ON Submission.assign_id = Assignment.assignment_id
                JOIN Course ON Assignment.course_id = Course.course_id';
            $where[] = 'Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->count('SELECT COUNT(*) AS count
            FROM Submission
            ' . $join . '
            ' . $this->where($where), $params);
    }

    private function sumHousePoints(?int $professorId): int
    {
        $params = [];
        $join = '';
        $where = [];

        if ($professorId) {
            $join = 'JOIN Submission ON HousePoints.submission_id = Submission.submission_id
                JOIN Assignment ON Submission.assign_id = Assignment.assignment_id
                JOIN Course ON Assignment.course_id = Course.course_id';
            $where[] = 'Course.professor_id = :professor_id';
            $params['professor_id'] = $professorId;
        }

        return $this->sum('SELECT SUM(HousePoints.points) AS total
            FROM HousePoints
            ' . $join . '
            ' . $this->where($where), $params);
    }

    private function sumHouseTotals(?int $professorId): int
    {
        if (!$professorId) {
            return $this->sum('SELECT SUM(total_points) AS total FROM House');
        }

        return $this->sumHousePoints($professorId);
    }

    private function count(string $sql, array $params = []): int
    {
        return (int) ($this->db->query($sql, $params)->find()['count'] ?? 0);
    }

    private function sum(string $sql, array $params = []): int
    {
        return (int) ($this->db->query($sql, $params)->find()['total'] ?? 0);
    }

    private function where(array $conditions): string
    {
        return $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
    }
}
