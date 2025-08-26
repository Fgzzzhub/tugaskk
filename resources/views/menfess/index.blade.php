<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-white">Menfess Cihuyy</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Menfess --}}
        <div class="bg-gray-800 text-gray-100 shadow-md rounded-xl p-6 mb-8">
            <form method="POST" action="{{ route('menfess.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-100">From</label>
                    <input type="text" name="from" placeholder="Sing sapa kie?"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-100 focus:border-indigo-500 sm:text-sm text-gray-900" required >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-100">To</label>
                    <input type="text" name="to" placeholder="Nggo sapa?"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900" required >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-100">Pesan</label>
                    <textarea name="message" placeholder="Pan ngomong apa..."
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900" rows="4" required ></textarea>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">
                    Kirim 
                </button>
            </form>
        </div>

        {{-- List Menfess --}}
        <h2 class="text-2xl font-semibold mb-4 text-white">Semua Menfess</h2>
        <div class="space-y-4">
            @foreach($menfesses as $m)
                <div class="bg-gray-800 shadow-md rounded-xl p-5 hover:shadow-lg transition">
                    <p class="text-sm text-gray-300">From: <span class="font-medium text-gray-100">{{ $m->from }}</span></p>
                    <p class="text-sm text-gray-300">To: <span class="font-medium text-gray-100">{{ $m->to }}</span></p>
                    <p class="mt-2 text-gray-10000">{{ $m->message }}</p>
                    <small class="text-gray-400 text-xs">{{ $m->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
