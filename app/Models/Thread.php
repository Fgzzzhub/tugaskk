<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonim',
        ]);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    // app/Models/Thread.php
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }
    public function isLikedBy(?\App\Models\User $user): bool
    {
        if (!$user) return false;
        return $this->likes->contains('user_id', $user->id);
    }
}
