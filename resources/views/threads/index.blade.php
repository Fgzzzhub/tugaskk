<x-app-layout>
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Daftar Threads</h1>
    <a href="{{ route('threads.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 hover:bg-blue-900 text-white rounded-lg shadow mt-2 mb-6 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round"
                 stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Thread
        </a>

    @foreach ($threads as $thread)
        <div class="bg-gray-200 shadow-md rounded-2xl p-6 mb-5 hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-black ">
                    {{ $thread->title }}
                </h2>   
                <span class="text-xs text-black">
                    {{ $thread->created_at->diffForHumans() }}
                </span>
            </div>
            <span class="text-sm text-gray-500">Pembuat: {{ $thread->user->name ?? 'Anonim' }}</span>
            <p class="text-black my-4">
                {{ Str::limit($thread->content, 120) }}
            </p>

            <div class="flex items-center justify-between text-sm text-black">
                <span>{{ $thread->comments->count() }} Komentar</span>
                <a href="{{ route('threads.show', $thread->id) }}"
                   class="px-3 py-1 rounded-xl bg-blue-900 text-white hover:bg-black transition duration-300">
                    Lihat Komentar
                </a>
            </div>
        </div>
    @endforeach
</div>

</x-app-layout>
