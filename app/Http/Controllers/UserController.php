<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = User::create([
            "email" => $request->email,
            "password" => $request->password,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Signup"
        ], 200);
    }
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                "status" => true,
                "message" => "Login Successful",
                "token" => Auth::user()->createToken("API TOKEN")->plainTextToken,
                "token_type" => "bearer"
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Email & Password does not match"
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            "status" => true,
            "message" => "Logout successful"
        ], 200);
    }
}
