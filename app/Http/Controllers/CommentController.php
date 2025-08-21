<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ThreadController;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $thread->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
