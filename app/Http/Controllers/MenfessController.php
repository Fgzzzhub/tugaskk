<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menfess;

class MenfessController extends Controller
{
    public function index()
    {
        $menfesses = Menfess::with('user')->latest()->paginate(10);
        return view('menfess.index', compact('menfesses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from'    => 'required|string|max:100',
            'to'      => 'required|string|max:100',
            'message' => 'required|string|max:1000',
        ]);

        Menfess::create([
            'user_id' => auth()->id(),
            'from'    => $validated['from'],
            'to'      => $validated['to'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Menfess berhasil dikirim!');
    }
}
