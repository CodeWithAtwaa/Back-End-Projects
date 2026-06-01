<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class StudentModel
{
    private $db;
    public function __construct()
    {

        $this->db =  App::resolve(Database::class);
    }

    public function CreateStudent($userId, $houseId)
    {
        $this->db->query('INSERT INTO Student (user_id,house_id) VALUES (:userId, :houseId)', [
            'userId'     => $userId,
            'houseId'    => $houseId,

        ]);
        return $this->db->connection->lastInsertId();
    }

    public function findStudent($studentId)
    {
        return $this->db->query('SELECT * FROM Student WHERE student_id = :student_id', [
            'student_id' => $studentId
        ])->find();
    }

    public function deductBalance($studentId, $price)
    {
        $this->db->query('UPDATE Student SET balance = balance - :price WHERE student_id = :student_id', [
            'student_id' => $studentId,
            'price'      => $price
        ]);
    }
}
