<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function register(array $data)
    {

        $user = $this->authRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return compact('user', 'token');
    }

    public function login(array $data)
    {
        $user = $this->authRepository->login($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $this->authRepository->deleteAllTokens($user);

        $token = $this->authRepository->createToken($user, 'auth_token');
        return compact('user', 'token');
    }

    public function logout($user)
    {
        $this->authRepository->deleteCurrentToken($user);
    }

}
