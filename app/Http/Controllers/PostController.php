<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): Collection
    {
        return Post::query()->latest()->get();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
        ]);

        $post = Post::query()->create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $request->get('image'),
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string',
        ]);

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $request->get('image'),
        ]);

        return response()->json($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
