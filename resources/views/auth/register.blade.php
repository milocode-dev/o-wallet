@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
  <div class="text-center mb-6">
    <h1 class="font-display text-xl font-bold text-forest-950">Buat Akun Baru</h1>
    <p class="text-sm text-forest-500 mt-1">Mulai catat keuanganmu di o-wallet.</p>
  </div>

  <form method="POST" action="{{ route('register.action') }}">
    @csrf

    <div class="mb-4">
      <label for="name" class="block text-sm font-medium text-forest-800 mb-1.5">Nama</label>
      <input type="text" id="name" name="name" placeholder="Isi nama anda" value="{{ old('name') }}"
             class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
      @error('name')
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
      @enderror
    </div>

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
      <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
             class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
      @error('password')
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="password_confirmation" class="block text-sm font-medium text-forest-800 mb-1.5">Konfirmasi Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password anda"
             class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
    </div>

    <button type="submit" class="w-full rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">
      Register
    </button>

    <p class="text-center text-sm text-forest-600 mt-4">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="font-medium text-forest-700 hover:text-forest-800">Login di sini</a>
    </p>
  </form>
@endsection
