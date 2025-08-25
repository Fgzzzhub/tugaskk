<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Thread;

class LikeController extends Controller
{
    public function toggle(Thread $thread)
    {
        $like = Like::where('thread_id', $thread->id)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'thread_id' => $thread->id,
                'user_id'   => auth()->id(),
            ]);
        }

        return back();
    }
}
