<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-6">
        <h1 class="text-2xl font-bold text-white mb-6">Buat Thread Baru</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('threads.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-white font-medium mb-2">Judul Thread</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required placeholder="Judul Thread">
            </div>

            <div>
                <label class="block text-white font-medium mb-2">Konten</label>
                <textarea name="content" rows="6"
                          class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('threads.index') }}" class="px-4 py-2 mr-3 rounded-lg border border-gray-300 text-gray-300 hover:bg-gray-700 duration-300">Batal</a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-700 hover:bg-blue-800 transition text-white shadow duration-300">
                    Simpan Thread
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
