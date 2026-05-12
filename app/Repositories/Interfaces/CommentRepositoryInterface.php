<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getByPostId(int $postId): Collection;
    public function addComment(array $data): Comment;
    public function deleteComment(Comment $comment): void;
}
