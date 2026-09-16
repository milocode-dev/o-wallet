@extends('layouts.app')

@section('title', 'Edit Dompet')

@section('content')
<div class="max-w-xl mx-auto" x-data="{ deleteOpen: false }">
  <a href="{{ route('wallet.show', $wallet->id) }}" class="flex items-center gap-1.5 text-sm text-forest-600 hover:text-forest-800 font-medium mb-6 w-fit">
    <x-icon name="chevron-left" class="w-4 h-4" />
    Batal
  </a>

  <div class="bg-white rounded-2xl border border-forest-100 p-6 md:p-8">
    <h1 class="font-display text-xl font-bold text-forest-950">Edit Dompet</h1>
    <p class="text-sm text-forest-500 mt-1">Perbarui informasi dompet di bawah ini.</p>

    <form method="POST" action="{{ route('wallet.update', $wallet->id) }}" class="mt-6">
      @csrf
      @method('PUT')
      @include('wallet.partials.form')

      <div class="mt-8 flex gap-3">
        <a href="{{ route('wallet.show', $wallet->id) }}" class="flex-1 text-center rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</a>
        <button type="submit" class="flex-1 rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">Simpan Perubahan</button>
      </div>
    </form>

    <div class="mt-6 pt-5 border-t border-forest-100">
      <button type="button" @click="deleteOpen = true" class="text-sm text-clay-600 hover:text-clay-700 font-medium">Hapus dompet ini</button>
    </div>
  </div>

  {{-- Modal: Konfirmasi Hapus --}}
  <div x-show="deleteOpen" x-cloak @click.self="deleteOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="deleteOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 mx-auto rounded-full bg-clay-50 text-clay-600 flex items-center justify-center">
        <x-icon name="warning" class="w-6 h-6" />
      </div>
      <h3 class="font-display text-lg font-bold text-forest-950 mt-4">Hapus dompet ini?</h3>
      <p class="text-sm text-forest-500 mt-1.5">Seluruh riwayat transaksi pada dompet ini akan ikut terhapus dan tidak bisa dikembalikan.</p>

      <form method="POST" action="{{ route('wallet.destroy', $wallet->id) }}" class="mt-6 flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
        <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Hapus</button>
      </form>
    </div>
  </div>
</div>
@endsection
