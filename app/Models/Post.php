<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function isResharedByUser($userId)
    {
        return $this->reshares()->where('user_id', $userId)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hiddenByUsers()
    {
        return $this->belongsToMany(User::class, 'hidden_posts');
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function reshares()
    {
        return $this->hasMany(Reshare::class);
    }
}
