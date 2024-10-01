<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')?->store('images', 'public');

        $post = Post::query()->create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $imagePath,
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post, 200);
    }

    public function update(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')?->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return response()->json($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
