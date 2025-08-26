@extends('layouts.app', ['title' => 'Threads'])

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Threads Terbaru</h1>
    @auth
    <a href="{{ route('threads.create') }}" class="text-sm px-3 py-1.5 rounded-md bg-brand text-white hover:bg-brand-dark">
        + Thread Baru
    </a>
    @endauth
</div>

@if ($threads->count() === 0)
    <div class="rounded-lg border bg-gray-800 p-6 text-gray-100">Belum ada thread.</div>
@else
    <div class="grid gap-4">
        @foreach ($threads as $thread)
            <article class="rounded-lg border bg-gray-800 p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <a href="{{ route('threads.show', $thread) }}" class="text-lg font-semibold hover:text-brand">
                            {{ $thread->title }}
                        </a>
                        <div class="text-sm text-gray-300 mt-1">
                            oleh <span class="font-medium text-gray-100">{{ $thread->user->name ?? 'Anonim' }}</span>
                            • {{ $thread->created_at?->diffForHumans() }}
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-100">
                        <span class="px-2 py-1 rounded-md bg-gray-800">{{ $thread->comments_count }} komentar</span>
                        <span class="px-2 py-1 rounded-md bg-gray-800">{{ $thread->likes_count }} suka</span>
                    </div>
                </div>

                <p class="mt-3 text-gray-100">
                    {{ \Illuminate\Support\Str::limit(strip_tags($thread->content), 220) }}
                </p>

                <div class="mt-4 flex items-center gap-2">
                    <a href="{{ route('threads.show', $thread) }}" class="text-sm px-3 py-1.5 rounded-md border bg-gray-800 hover:bg-gray-50 hover:text-black">
                        Lihat
                    </a>

                    @auth
                    <form action="{{ route('threads.like', $thread) }}" method="POST">
                        @csrf
                        <button class="text-sm px-3 py-1.5 rounded-md bg-brand text-white hover:bg-brand-dark">
                            Suka / Batal
                        </button>
                    </form>
                    @endauth
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">
        {{-- Paginator Laravel sudah bergaya Tailwind --}}
        {{ $threads->links() }}
    </div>
@endif
@endsection
