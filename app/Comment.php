<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'post_id',
        'user_id',
        'reply_id',
        'body',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class); // one comment only one post
    }

    public function user()
    {
        return $this->belongsTo(User::class); // one user can one comment under one post
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }



}
