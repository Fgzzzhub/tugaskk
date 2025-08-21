<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menfess extends Model
{
    use HasFactory;

    // app/Models/Menfess.php
    protected $fillable = ['user_id', 'from', 'to', 'message'];


    // app/Models/Menfess.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
