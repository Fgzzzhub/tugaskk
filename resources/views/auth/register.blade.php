@extends('layouts.app', ['title' => 'Register'])

@section('content')

<form method="POST" action="{{ route('register') }}" class="space-y-4">
  @csrf

  {{-- Name --}}
  <div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" type="text" name="name"
      class="mt-1 block w-full"
      :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
  </div>

  {{-- Email --}}
  <div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" type="email" name="email"
      class="mt-1 block w-full"
      :value="old('email')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
  </div>

  {{-- Password --}}
  <div>
    <x-input-label for="password" :value="__('Password')" />
    <x-text-input id="password" type="password" name="password"
      class="mt-1 block w-full"
      required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
  </div>

  {{-- Confirm --}}
  <div>
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
    <x-text-input id="password_confirmation" type="password" name="password_confirmation"
      class="mt-1 block w-full"
      required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
  </div>

  <div class="flex items-center justify-between">
    <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400" href="{{ route('login') }}">
Sudah memiliki akun?
    </a>
  </div>

  <x-primary-button class="w-full justify-center">
Register
  </x-primary-button>
</form>

@endsection