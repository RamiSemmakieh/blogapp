<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment; // Make sure to import the Comment model
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|string',
        ]);

        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Create a new comment data array with the content, post_id, and user_id
            $commentData = [

                'content' => $request->input('content'),
                'post_id' => $post->id,
                'user_id' => $userId,
            ];
           
            // Insert the comment into the database
            $comment = Comment::create($commentData, $post->id, $userId);
            
            
        } else {
            // Handle the case where the user is not authenticated
            // You may choose to do something different in this case, such as redirecting to the login page or showing an error message
            return redirect()->back()->with('error', 'You must be logged in to comment.');
        }



        // Optionally, you can return a response or redirect
        return redirect()->route('home', $post);
    }
}
