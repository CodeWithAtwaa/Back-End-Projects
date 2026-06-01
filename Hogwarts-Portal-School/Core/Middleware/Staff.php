<?php

namespace Core\Middleware;

class Staff
{
    public function handle()
    {
        if (!current_user()) {
            header('Location: /');
            exit();
        }

        if (!is_staff()) {
            \abort(403);
        }
    }
}
