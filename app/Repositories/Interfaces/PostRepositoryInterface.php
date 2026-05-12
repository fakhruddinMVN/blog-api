<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAll(int $perPage = 20): LengthAwarePaginator;
    public function findById(int $id): ?Post;
    // public function create(Post $post, array $data): Post;
    public function create(array $data): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): void;
}
