<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAll(int $perPage = 20): LengthAwarePaginator
    {
        return Post::with('user:id,name')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Post
    {
        return Post::with('user:id,name')->find($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

}
