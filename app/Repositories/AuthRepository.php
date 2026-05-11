<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(string $email): ?User
    {
        return User::where("email", $email)->first();
    }

    public function create(array $data): User
    {
        return User::create(
            $data
        );
    }

    public function deleteAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    public function createToken(User $user, string $tokenName): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function deleteCurrentToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
