<x-app-layout>
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-gray-200 shadow-lg rounded-2xl p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-3">
            {{ $thread->title }}
        </h1>
        <p class="text-gray-700 mb-4">
            {{ $thread->body }}
        </p>
        <span class="text-sm text-gray-500">Pembuat: {{ $thread->user->name ?? 'Anonim' }}</span>
    </div>

    <div class="bg-gray-200 shadow-md rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Komentar</h2>

        @forelse ($thread->comments as $comment)
            <div class="mb-4 border-b pb-3">
                <p class="text-gray-800">
                    <strong>{{ $comment->user->name ?? 'Anonim' }}</strong>:
                    {{ $comment->body }}
                </p>
                <span class="text-xs text-gray-500">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
        @empty
            <p class="text-gray-500">Belum ada komentar.</p>
        @endforelse

        @auth
            <form action="{{ route('comments.store', $thread->id) }}" method="POST" class="mt-6">
                @csrf
                <textarea name="body" rows="3"
                          class="w-full border rounded-xl p-3 focus:ring focus:ring-blue-300"
                          placeholder="Tulis komentar..."></textarea>
                <button type="submit"
                        class="mt-3 px-4 py-2 bg-blue-900 text-white rounded-xl hover:bg-black duration-300 transition">
                    Kirim
                </button>
            </form>
        @else
            <p class="text-sm text-gray-500 mt-4">Login untuk menulis komentar.</p>
        @endauth
    </div>
</div>

</x-app-layout>
