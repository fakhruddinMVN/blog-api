<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function getByPostId(int $postId): Collection
    {
        return Comment::with("user:id, name")->where("postID", $postId)->latest()->get();
    }

    public function addComment(array $data): Comment
    {
        return Comment::create($data);
    }

    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
    }

}
