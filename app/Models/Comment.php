<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['content', 'user_id', 'post_id'];

    // Define the relationship with the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
