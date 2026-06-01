<?php

namespace Core\Middleware;

class Guest
{
    public function handle()
    {
        if (current_user()) {
            header('Location: /');
            exit();
        }
    }
}
