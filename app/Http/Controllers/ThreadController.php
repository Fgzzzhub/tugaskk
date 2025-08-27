<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    // Pastikan hanya pengguna login yang bisa create/store
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    public function index()
    {
        $threads = Thread::latest()->paginate(10);
        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body'  => ['required', 'string'],
        ]);

        $thread = Thread::create([
            'title'   => $data['title'],
            'body'    => $data['body'],
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('threads.show', $thread)
            ->with('success', 'Thread berhasil dibuat.');
    }

    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }
}
