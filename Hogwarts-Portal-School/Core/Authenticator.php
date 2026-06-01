<?php

namespace Core;

use Http\Models\UserModel;

class Authenticator
{
    public function attempt($email, $password)
    {
        $userModel = new UserModel();
        $user = $userModel->findUserWithStudent($email);

        if ($user) {
            if (password_verify($password, $user['password']) || hash_equals($user['password'], $password)) {
                $this->login($user);
                return true;
            }
        }
        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'user_id' => $user['user_id'] ?? null,
            'user_name' => $user['user_name'] ?? null,
            'email' => $user['email'],
            'role' => $user['role'] ?? null,
            'student_id' => $user['student_id'] ?? null,
            'house_id' => $user['house_id'] ?? null,
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
