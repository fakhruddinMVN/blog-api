<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function __construct(private PostService $postService){}

    public function index(): AnonymousResourceCollection
    {
        $posts = $this->postService->getAllPosts();

        $post = $this->postService->getPostById(1);

        return PostResource::collection($posts);
    }

    public function getPost(int $postId): JsonResponse
    {
        $post = $this->postService->getPostById($postId);

        if (! $post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

        return response()->json(new PostResource($post));
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
