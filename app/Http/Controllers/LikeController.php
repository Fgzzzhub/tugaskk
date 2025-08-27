<?php

// app/Http/Controllers/LikeController.php
namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Thread $thread)
    {
        $user = $request->user();

        $existing = Like::where('thread_id', $thread->id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($existing) {
            $existing->delete();
            $status = 'unliked';
        } else {
            Like::create([
                'thread_id' => $thread->id,
                'user_id'   => $user->id,
            ]);
            $status = 'liked';
        }

        // Kembali ke halaman sebelumnya
        if ($request->expectsJson()) {
            return response()->json(['status' => $status, 'likes_count' => $thread->likes()->count()]);
        }

        return back();
    }
}
