@if (session('success'))
    <div class="mb-4 rounded-md border-l-4 border-green-500 bg-green-50 p-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-md border-l-4 border-red-500 bg-red-50 p-3 text-sm text-red-700">
        <div class="font-semibold mb-1">Ada beberapa kesalahan:</div>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
