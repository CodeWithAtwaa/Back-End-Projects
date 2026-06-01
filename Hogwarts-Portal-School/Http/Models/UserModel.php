<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class UserModel
{
    private $db;
    public function __construct()
    {

        $this->db =  App::resolve(Database::class);
    }
    public function FindUser($email)
    {
        return $this->db->query('select * from User where email = :email', [
            'email' => $email
        ])->find();
    }
    public function CreateUser($name, $email, $password)
    {
        $this->db->query('INSERT INTO User (user_name, email, password, role) VALUES (:name, :email, :password, :role)', [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'role'     => 'Student'
        ]);
        return $this->db->connection->lastInsertId();
    }
    public function findUserWithStudent($email)
    {
        return $this->db->query(
            'SELECT User.*, Student.student_id, Student.house_id
         FROM User
         LEFT JOIN Student ON User.user_id = Student.user_id
         WHERE User.email = :email',
            ['email' => $email]
        )->find();
    }
}
