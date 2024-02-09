<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments.user')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Return view for creating a new post
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        try {
            $post = new Post();
            $post->title = $validatedData['title'];
            $post->body = $validatedData['body'];
            $post->user_id = Auth::id(); // Use Auth::id() to get the authenticated user's ID
            $post->save();

            return redirect()->route('home')->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create blog post.');
        }
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Return view for editing a post
    }

    public function update(Request $request, Post $post)
    {
        // Update the specified post in storage
    }

    public function destroy(Post $post)
    {
        // Delete the specified post from storage
    }
}
