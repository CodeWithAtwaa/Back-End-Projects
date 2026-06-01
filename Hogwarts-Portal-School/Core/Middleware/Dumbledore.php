<?php

namespace Core\Middleware;

class Dumbledore
{
    public function handle()
    {
        if (!current_user()) {
            header('Location: /');
            exit();
        }

        if (!is_dumbledore()) {
            \abort(403);
        }
    }
}
