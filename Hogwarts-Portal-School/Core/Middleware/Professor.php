<?php

namespace Core\Middleware;

class Professor
{
    public function handle()
    {
        if (!current_user()) {
            header('Location: /');
            exit();
        }

        if (!is_professor()) {
            \abort(403);
        }
    }
}
