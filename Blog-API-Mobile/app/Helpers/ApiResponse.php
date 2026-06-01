<?php

namespace App\Helpers;

class ApiResponse
{
    public static function response($code = 201, $message = null, $data = null)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
