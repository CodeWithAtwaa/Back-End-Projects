<?php

namespace Core\Middleware;

class Auth
{
    public function handle()
    {
        if (!current_user()) {
            header('Location: /');
            exit();
        }
    }
}
