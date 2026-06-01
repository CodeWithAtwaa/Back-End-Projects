<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class,
        'student' => Student::class,
        'dumbledore' => Dumbledore::class,
        'professor' => Professor::class,
        'staff' => Staff::class
    ];

    public static function resolve($type)
    {
        if(!$type)
            return;

        $middleware = self::MAP[$type] ?? false;

        if (! $middleware) {
            throw new \Exception("No such middleware found '{$type}'");
        }

        return (new $middleware)->handle();
    }
}
