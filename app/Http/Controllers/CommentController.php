<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
Use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $users = Auth::user()->id;
        $validatedData = $request->validate([
            'body' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = Comment::create([
            'user_id' => $users->id,
            'post_id' => $validatedData['post_id'],
            'body' => $validatedData['body'],
        ]);

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }

    public function show() // Show All posts
    {
        $posts = Comment::select(['id', 'post_id', 'body'])
            ->get();
        return response()->json($posts);
    }


}
