<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function index()
    {
        // Eager-load user & counts agar hemat query
        $threads = Thread::with(['user:id,name'])
            ->withCount(['comments','likes'])
            ->latest()
            ->paginate(10);

        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        // Muat relasi untuk tampilan detail
        $thread->load([
            'user:id,name',
            'comments.user:id,name',
            'likes',
        ])->loadCount(['comments','likes']);

        return view('threads.show', compact('thread'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string|max:5000',
        ]);

        Thread::create([
            'user_id' => auth()->id(),
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread berhasil diposting!');
    }
}
