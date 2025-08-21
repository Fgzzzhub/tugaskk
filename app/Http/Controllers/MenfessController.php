<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menfess;

class MenfessController extends Controller
{
    public function index()
    {
        $menfesses = Menfess::with('user')->latest()->get();
        return view('menfess.index', compact('menfesses'));
    }
   // app/Http/Controllers/MenfessController.php
public function store(Request $request)
{
    $request->validate([
        'from' => 'required|string|max:255',
        'to' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    Menfess::create([
        'user_id' => auth()->id(),
        'from' => $request->from,
        'to' => $request->to,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Menfess berhasil dikirim!');
}

}
