<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;   // <-- Tambahkan ini
use App\Models\Comment;  // kalau kamu pakai Comment
use App\Models\Like;     // kalau kamu pakai Like
use App\Models\User;     // kalau ada relasi ke User


class ThreadController extends Controller
{
    public function index()
{
    $threads = Thread::with('comments')->get();
    return view('threads.index', compact('threads'));
}


     // Menampilkan halaman detail thread
     public function show($id)
{
    $thread = Thread::with('comments')->findOrFail($id);
    return view('threads.show', compact('thread'));
}


    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Thread::create([
            'user_id' => auth()->id(),
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Thread berhasil diposting!');
    }

    public function create()
{
    return view('threads.create');
}

}
