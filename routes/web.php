<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenfessController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::middleware('auth')->group(function () {
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});


Route::get('/', function () {
    return redirect()->route('threads.index');
});

// Dashboard (login required)
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/register', function() {
    return view('auth.register');
});

Route::get('/login', function() {
    return view('auth.login');
});

// Threads (index & show publik; create/store butuh login)

Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');



// Menfess
Route::get('/menfess', [MenfessController::class, 'index'])->name('menfess.index');
Route::post('/menfess', [MenfessController::class, 'store'])->middleware('auth')->name('menfess.store');


// Komentar & Like (wajib login)
// Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
//     ->middleware('auth')->name('comments.store');

// Route::post('/threads/{thread}/like', [LikeController::class, 'toggle'])
//     ->middleware('auth')->name('threads.like');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';
