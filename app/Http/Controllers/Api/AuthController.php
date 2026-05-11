<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json(['message' => 'User registered successfully Complete.', 'user' => $result['user'], 'token' => $result['token']], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());


        return response()->json(['message' => 'User logged in successfully.', 'user' => $result['user'], 'token' => $result['token']], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'User logged out successfully.'], 200);
    }

    // GET /api/user  (get currently logged-in user)
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
