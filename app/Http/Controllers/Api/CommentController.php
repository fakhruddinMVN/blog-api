<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentPostRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Js;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService, private PostService $postService, )
    {
    }

    public function index(int $postId): AnonymousResourceCollection
    {
        $comments = $this->commentService->getComment($postId);

        return CommentResource::collection($comments);
    }

    public function addComment(CommentPostRequest $request, Post $post): JsonResponse
    {
        $comment =$this->commentService->addComment(
            $post,
            $request->validated(),
            $request->user()->id,
        );

        $comment->load('user');

        return response()->json([
            "message"=> "Comment added successfully",
            "comment"=> $comment,
        ], 201);
    }

    public function deleteComment(Comment $comment): JsonResponse
    {
        $this->authorize("delete", $comment);
        $this->commentService->deleteComment($comment);

        return response()->json([
            "message"=> "Comment deleted successfully",
        ]);
    }
}
