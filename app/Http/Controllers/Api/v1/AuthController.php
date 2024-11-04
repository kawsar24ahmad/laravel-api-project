<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;


use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function signup(SignupRequest $request): JsonResponse{

        try {
            $user = User::create([
                "name"=> $request->name,
                "email"=> $request->email,
                "password"=> bcrypt($request->password),
            ]);

            return response()->json([
                "status"=> true,
                "message"=> "User created successfully",
                "user" => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "User registration failed",
                "error" => $e->getMessage(),
            ], 500);
        }

    }

    public function login(LoginRequest $request) : JsonResponse {

        $credentials = [
            "email"=> $request->email,
            "password"=> $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                "status"=> true,
                "message" => "User Logged in successfully!",
                "user"=> $user,
                'token' => $user->createToken('AppToken')->plainTextToken,
                'token_type' =>  'bearer'
            ], 200);
        }

        return response()->json([
            "status"=> false,
            "message" => "Invalid credentials! User not logged in.",
        ], 401);
    }

    public function logout() : JsonResponse {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Logged Out Successfully!",
        ],200);
    }
}
