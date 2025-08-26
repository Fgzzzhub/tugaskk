<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input id="remember" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">Remember me</span>
            </label>
            <div class="flex items-center justify-between">
                <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400"
                    href="{{ route('login') }}">Sudah Memiliki Akun?</a>
            </div>
        </div>
        <x-primary-button class="w-full justify-center">Log in</x-primary-button>
    </form>
</x-guest-layout>
