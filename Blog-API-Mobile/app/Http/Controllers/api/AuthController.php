<?php

namespace App\Http\Controllers\api;


use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Check validation
        if ($validator->fails()) {
            return ApiResponse::response(422, "Validation Error", $validator->errors());
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return response
        return ApiResponse::response(201, "User Created Successfully", [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check validation
        if ($validator->fails()) {
            return ApiResponse::response(422, "Validation Error", $validator->errors());
        }

        // Check email
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::response(401, "Unauthorized");
        }

        // Return response
        return ApiResponse::response(200, "Login Successfully", [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::response(200, "Logout Successfully");
    }
}
