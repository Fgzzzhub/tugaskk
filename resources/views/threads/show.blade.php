@extends('layouts.app', ['title' => $thread->title])

@section('content')
<article class="rounded-lg border bg-white p-5">
    <h1 class="text-2xl font-bold">{{ $thread->title }}</h1>
    <div class="mt-1 text-sm text-gray-500">
        oleh <span class="font-medium text-gray-700">{{ $thread->user->name ?? 'Anonim' }}</span>
        • {{ $thread->created_at?->diffForHumans() }}
        • <span class="px-2 py-0.5 rounded bg-gray-100">{{ $thread->comments_count }} komentar</span>
        • <span class="px-2 py-0.5 rounded bg-gray-100">{{ $thread->likes_count }} suka</span>
    </div>

    <div class="mt-4 whitespace-pre-line text-gray-800">
        {{ $thread->content }}
    </div>

    <div class="mt-4 flex items-center gap-2">
        @auth
        <form action="{{ route('threads.like', $thread) }}" method="POST">
            @csrf
            <button class="text-sm px-3 py-1.5 rounded-md bg-brand text-white hover:bg-brand-dark">
                Suka / Batal
            </button>
        </form>
        @endauth
        <a href="{{ route('threads.index') }}" class="text-sm px-3 py-1.5 rounded-md border hover:bg-gray-50">
            Kembali
        </a>
    </div>
</article>

{{-- KOMENTAR --}}
<section class="mt-6 rounded-lg border bg-white p-5">
    <h2 class="text-lg font-semibold mb-3">Komentar</h2>

    @auth
    <form action="{{ route('comments.store', $thread) }}" method="POST" class="mb-4">
        @csrf
        <label class="block text-sm font-medium">Tulis komentar</label>
        <textarea name="body" rows="3" class="mt-1 w-full rounded-md border-gray-300 focus:border-brand focus:ring-brand" placeholder="Pendapatmu...">{{ old('body') }}</textarea>
        <div class="mt-2">
            <button class="text-sm px-3 py-1.5 rounded-md bg-brand text-white hover:bg-brand-dark">Kirim</button>
        </div>
    </form>
    @else
        <div class="mb-4 rounded-md bg-yellow-50 border-l-
