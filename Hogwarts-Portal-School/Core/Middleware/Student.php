<?php

namespace Core\Middleware;

class Student
{
    public function handle()
    {
        if (!current_user()) {
            header('Location: /');
            exit();
        }

        if (!is_student()) {
            \abort(403);
        }
    }
}
