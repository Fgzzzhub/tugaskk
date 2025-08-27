<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenfessController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Menfess
Route::get('/menfess', [MenfessController::class, 'index'])->name('menfess.index');
Route::post('/menfess', [MenfessController::class, 'store'])->name('menfess.store');

// Threads
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    // Route::get('/menfess', [MenfessController::class, 'index']);
    // Route::post('/menfess', [MenfessController::class, 'store'])->name('menfess.store');

});

require __DIR__ . '/auth.php';


// Route::middleware('auth')->group(function () {
//     Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
//     Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');


Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::middleware(['auth'])->group(function () {
    Route::post('/threads/{thread}/like', [LikeController::class, 'toggle'])
        ->whereNumber('thread')
        ->name('threads.like');
});

Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

// });