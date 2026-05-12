<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function getAllPosts(): LengthAwarePaginator
    {
        return $this->postRepository->getAll();
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

    public function createPost(array $data, int $userId): Post
    {
        return $this->postRepository->create([
            "user_id" => $userId,
            "title" => $data["title"],
            "content" => $data["content"],
        ]);
    }

    public function updatePost(Post $post, array $data): Post
    {
        return $this->postRepository->update($post, [
            "title" => $data["title"] ?? $post->title,
            "content" => $data["content"] ?? $post->content,
        ]);
    }

    public function deletePost(Post $post): void
    {
        $this->postRepository->delete($post);
    }
}
