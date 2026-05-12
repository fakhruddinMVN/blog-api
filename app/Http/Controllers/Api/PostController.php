<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService){}

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();

        return response()->json($posts);
    }

    public function getPost(int $postId): JsonResponse
    {
        $post = $this->postService->getPostById($postId);
        return response()->json($post);
    }

    public function createPost(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->createPost(
            $request->validated(),
            $request->user()->id,
        );

        return response()->json([
            'message' => 'Post created successfully.',
            'post' => $post,
        ],201);
    }

    public function updatePost(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $post = $this->postService->updatePost($post, $request->validated());
        return response()->json([
            'message' => 'Post updated successfully.',
            'post' => $post,
        ]);
    }

    public function deletePost(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $this->postService->deletePost($post);

        return response()->json([
            'message'=> 'Post delete successfully.',
        ]);
    }

}
