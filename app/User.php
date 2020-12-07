<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return Storage::url($this->profileImage->path);
    }

    public function role()
    {
        return $this->belongsTo(Role::class); // one user for one role
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeWithMostPosts(Builder $builder)
    { // most active users who are posts more
        return $builder->withCount('posts')->orderBy('posts_count', 'desc');
    }

    public function scopeMostActiveUsersLastMonth(Builder $builder)
    {
        return $builder->withCount(['posts' => function (Builder $builder) {
            $builder->whereBetween(static::CREATED_AT, [now()->subMonth(1), now()]);
        }])->having('posts_count', '>=', 2)
            ->orderBy('posts_count', 'desc');
    }

    public function favorite_posts()  /* one user can favarite more post*/
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); // one user can comment more
    }


    public function scopeAuthors($query)
    {
        return $query->where('role_id', 2);
    }


    public function profileImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


}
