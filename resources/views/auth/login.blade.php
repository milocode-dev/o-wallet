@extends('layouts.guest')

@section('title', 'Login')

@section('content')
  <div class="text-center mb-6">
    <h1 class="font-display text-xl font-bold text-forest-950">Selamat Datang!</h1>
    <p class="text-sm text-forest-500 mt-1">Masuk dengan akun pengguna.</p>
  </div>

  @if (session('success'))
    <div class="mb-4 rounded-xl bg-forest-100 text-forest-700 text-sm font-medium px-4 py-3 text-center">
      {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="mb-4 rounded-xl bg-clay-50 text-clay-700 text-sm font-medium px-4 py-3 text-center">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.action') }}">
    @csrf

    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-forest-800 mb-1.5">E-mail</label>
      <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}"
             class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
      @error('email')
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="password" class="block text-sm font-medium text-forest-800 mb-1.5">Password</label>
      <input type="password" id="password" name="password" placeholder="Isi password anda"
             class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
      @error('password')
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="w-full rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">
      Login
    </button>

    <p class="text-center text-sm text-forest-600 mt-4">
      Belum punya akun?
      <a href="{{ route('register') }}" class="font-medium text-forest-700 hover:text-forest-800">Daftar sekarang</a>
    </p>
  </form>
@endsection
