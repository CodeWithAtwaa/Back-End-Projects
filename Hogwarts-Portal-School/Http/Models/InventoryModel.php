<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class InventoryModel
{
    private $db;
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function findItem($studentId, $itemId)
    {
        return $this->db->query(
            'SELECT * FROM Inventory WHERE student_id = :student_id AND item_id = :item_id',
            [
                'student_id' => $studentId,
                'item_id'    => $itemId
            ]
        )->find();
    }

    public function addItem($studentId, $itemId)
    {
        $this->db->query(
            'INSERT INTO Inventory (student_id, item_id, quantity) VALUES (:student_id, :item_id, 1)',
            [
                'student_id' => $studentId,
                'item_id'    => $itemId
            ]
        );
    }

    public function incrementItem($studentId, $itemId)
    {
        $this->db->query(
            'UPDATE Inventory SET quantity = quantity + 1 WHERE student_id = :student_id AND item_id = :item_id',
            [
                'student_id' => $studentId,
                'item_id'    => $itemId
            ]
        );
    }

    public function decrementItem($studentId, $itemId)
    {
        $this->db->query(
            'UPDATE Inventory SET quantity = quantity - 1 WHERE student_id = :student_id AND item_id = :item_id AND quantity > 1',
            [
                'student_id' => $studentId,
                'item_id'    => $itemId
            ]
        );
    }

    public function removeItem($studentId, $itemId)
    {
        $this->db->query(
            'DELETE FROM Inventory WHERE student_id = :student_id AND item_id = :item_id',
            [
                'student_id' => $studentId,
                'item_id'    => $itemId
            ]
        );
    }

    public function getAllItems($studentId)
    {
        return $this->db->query('SELECT
                Inventory.item_id,
                Inventory.quantity,
                DiagonAlleyShop.item_name,
                DiagonAlleyShop.item_price,
                DiagonAlleyShop.item_type
            FROM Inventory
            JOIN DiagonAlleyShop ON Inventory.item_id = DiagonAlleyShop.item_id
            WHERE Inventory.student_id = :id
        ', [
            'id' => $studentId
        ])->get();
    }
}
