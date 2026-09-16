@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
  <h1 class="font-display text-2xl md:text-3xl font-bold text-forest-950">Halo, {{ $user->name }}</h1>
  <p class="mt-1.5 text-forest-600">
    Total saldo dari {{ $wallets->count() }} dompet:
    <span class="font-semibold text-forest-800 tnum">Rp {{ number_format($wallets->sum('nominal'), 0, ',', '.') }}</span>
  </p>

  <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    @foreach ($wallets as $wallet)
      @include('wallet.partials.card', ['wallet' => $wallet])
    @endforeach

    <a href="{{ route('wallet.create') }}"
       class="rounded-2xl p-5 border-2 border-dashed border-forest-200 flex flex-col items-center justify-center gap-2 text-forest-500 hover:border-forest-400 hover:text-forest-600 hover:bg-forest-100/60 transition-colors min-h-[168px]">
      <div class="w-10 h-10 rounded-full bg-forest-100 flex items-center justify-center">
        <x-icon name="plus" class="w-5 h-5" />
      </div>
      <span class="text-sm font-medium">Tambah Dompet</span>
    </a>

  </div>

  @if ($wallets->isEmpty())
    <p class="mt-4 text-sm text-forest-500">Kamu belum punya dompet. Yuk tambahkan dompet pertamamu.</p>
  @endif
</div>
@endsection
