<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use App\Models\User;

interface AuthRepositoryInterface
{
    public function create(array $data): User;
    public function login(string $email): ?User;
    public function deleteAllTokens(User $user): void;
    public function createToken(User $user, string $tokenName): string;
    public function deleteCurrentToken(User $user): void;
}
