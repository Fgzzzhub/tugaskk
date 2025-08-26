<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FgzzzApp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        -tailwind.config = {
            /* ...custom colors if any... */
        }; -
    </script>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        (() => {
            
            const t = localStorage.getItem('theme'); 
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches; 
            if (t === 'dark' || (!t && prefersDark)) document.documentElement.classList.add('dark'); 
            else document.documentElement.classList.remove('dark'); 
        })(); 
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#4f46e5',
                            dark: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    
    {{-- NAVBAR --}}
    <header class="bg-gray-900 text-gray-100 shadow-sm sticky top-0 z-50">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex h-14 items-center justify-between">
                <a href="{{ route('threads.index') }}" class="font-semibold tracking-tight text-brand">
                    FgzzzApp
                </a>

                <nav class="flex items-center gap-4">
                    <a href="{{ route('threads.index') }}" class="text-sm hover:text-brand">Threads</a>
                    <a href="{{ route('menfess.index') }}" class="text-sm hover:text-brand">Menfess</a>

                    @auth
                        <a href="{{ route('threads.create') }}"
                            class="text-sm px-3 py-1.5 rounded-md bg-brand text-white hover:bg-brand-dark">
                            Buat Thread
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm px-3 py-1.5 rounded-md border hover:bg-gray-100">
                                Keluar
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-sm hover:text-brand">Masuk</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm px-3 py-1.5 rounded-md border hover:bg-gray-700">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="mx-auto max-w-6xl px-4 py-6">
        @include('partials.flash')
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t bg-gray-900">
        <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-gray-100">
            &copy; {{ date('Y') }} FgzzzApp. Dibuat dengan Laravel.
        </div>
    </footer>
</body>

</html>
