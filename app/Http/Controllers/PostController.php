<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() // Show Post of the particular user
    {
        // Retrieve posts of the authenticated user
        $user = Auth::user();
        $posts = $user->posts()->select(['id', 'post_title', 'post_content'])->get();
        return response()->json(['posts' => $posts], 200);
    }

    public function show() // Show All posts
    {
        $posts = Post::select(['id', 'post_title', 'post_content'])
            ->get();
        return response()->json($posts);
    }
    public function store(Request $request) // Add New Posts
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
        ]);
        $post = new Post([
            'post_title' => $validatedData['post_title'],
            'post_content' => $validatedData['post_content'],
        ]);

        $user->posts()->save($post);

        return response()->json(['message' => 'Post created successfully'], 201);
    }
    public function edit(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'You do not have permission to edit this post.'], 403);
        }
        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
        ]);

        // Update the post
        $post->update($validatedData);

        return response()->json(['message' => 'Post updated successfully'], 200);
    }


    // ...

    public function update(Request $request, $id)
    {
        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        // Check if the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'You do not have permission to edit this post.'], 403);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
        ]);

        // Update the post
        $post->update($validatedData);

        return response()->json(['message' => 'Post updated successfully'], 200);
    }


// ...

public function destroy($id)
{
    // Find the post by ID
    $post = Post::find($id);

    // Check if the post exists
    if (!$post) {
        return response()->json(['message' => 'Post not found.'], 404);
    }

    // Check if the post belongs to the authenticated user
    if ($post->user_id !== auth()->id()) {
        return response()->json(['message' => 'You do not have permission to delete this post.'], 403);
    }

    // Delete the post
    $post->delete();

    return response()->json(['message' => 'Post deleted successfully'], 200);
}

}
