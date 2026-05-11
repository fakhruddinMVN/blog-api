<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'User registered successfully Complete.', 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validation['email'])->first();

        if (!$user || !Hash::check($validation['password'], $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'User logged in successfully.', 'user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully.'], 200);
    }

    // GET /api/user  (get currently logged-in user)
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
