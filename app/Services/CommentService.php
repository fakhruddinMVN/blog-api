<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    public function getComment(int $postId): Collection
    {
        return $this->commentRepository->getByPostId($postId);
    }

    public function addComment(Post $post, array $data, int $userId): Comment
    {
        return $this->commentRepository->addComment([
            'post_it' => $post->id,
            'user_id' => $userId,
            'content' => $data['content'],
        ]);
    }

    public function deleteComment(Comment $comment): void
    {
        $this->commentRepository->deleteComment($comment);
    }
}
