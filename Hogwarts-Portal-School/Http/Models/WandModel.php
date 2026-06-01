<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class WandModel
{
    private $db;
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function CreateWand($studentId, $wood, $core)
    {
        $this->db->query(
            'INSERT INTO Wand (student_id, wood_type, core_type) VALUES (:studentId, :wood, :core)',
            [
                'studentId' => $studentId,
                'wood'      => $wood,
                'core'      => $core
            ]
        );
    }

    public function findWand($studentId)
    {
        return $this->db->query(
            'SELECT * FROM Wand WHERE student_id = :student_id',
            ['student_id' => $studentId]
        )->find();
    }
}