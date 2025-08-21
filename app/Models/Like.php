<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['thread_id', 'user_id'];

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
