@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="max-w-xl mx-auto" x-data="{ deleteOpen: false }">
  <a href="{{ route('wallet.show', $transaction->wallet_id) }}" class="flex items-center gap-1.5 text-sm text-forest-600 hover:text-forest-800 font-medium mb-6 w-fit">
    <x-icon name="chevron-left" class="w-4 h-4" />
    Batal
  </a>

  <div class="bg-white rounded-2xl border border-forest-100 p-6 md:p-8">
    <h1 class="font-display text-xl font-bold text-forest-950">Edit Transaksi</h1>
    <p class="text-sm text-forest-500 mt-1">
      {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }} pada dompet ini.
    </p>

    <form method="POST" action="{{ route('transaction.update', $transaction->id) }}" class="mt-6 space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-sm font-medium text-forest-800 mb-1.5">Catatan</label>
        <input type="text" name="name" id="name" required value="{{ old('name', $transaction->name) }}"
               class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
        @error('name') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="nominal" class="block text-sm font-medium text-forest-800 mb-1.5">Nominal</label>
        <div class="relative">
          <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-forest-400">Rp</span>
          <input type="number" min="1" step="1" name="nominal" id="nominal" required
                 value="{{ old('nominal', $transaction->nominal) }}"
                 class="w-full rounded-xl border border-forest-150 pl-10 pr-3.5 py-2.5 text-sm tnum focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
        </div>
        @error('nominal') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="category_id" class="block text-sm font-medium text-forest-800 mb-1.5">Kategori</label>
        <select name="category_id" id="category_id"
                class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm text-forest-800 focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">
          <option value="">Tanpa kategori</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('category_id', $transaction->category_id) == $cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>
        @error('category_id') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="transaction_date" class="block text-sm font-medium text-forest-800 mb-1.5">Tanggal</label>
        <input type="date" name="transaction_date" id="transaction_date" required
               value="{{ old('transaction_date', \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('Y-m-d')) }}"
               class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
        @error('transaction_date') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-forest-800 mb-1.5">Deskripsi <span class="text-forest-400 font-normal">(opsional)</span></label>
        <textarea name="description" id="description" rows="3"
                  class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">{{ old('description', $transaction->description) }}</textarea>
        @error('description') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex gap-3 pt-2">
        <a href="{{ route('wallet.show', $transaction->wallet_id) }}" class="flex-1 text-center rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</a>
        <button type="submit" class="flex-1 rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">Simpan Perubahan</button>
      </div>
    </form>

    <div class="mt-6 pt-5 border-t border-forest-100">
      <button type="button" @click="deleteOpen = true" class="text-sm text-clay-600 hover:text-clay-700 font-medium">Hapus transaksi ini</button>
    </div>
  </div>

  {{-- Modal: Konfirmasi Hapus --}}
  <div x-show="deleteOpen" x-cloak @click.self="deleteOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="deleteOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 mx-auto rounded-full bg-clay-50 text-clay-600 flex items-center justify-center">
        <x-icon name="warning" class="w-6 h-6" />
      </div>
      <h3 class="font-display text-lg font-bold text-forest-950 mt-4">Hapus transaksi ini?</h3>
      <p class="text-sm text-forest-500 mt-1.5">Saldo dompet akan disesuaikan kembali secara otomatis.</p>

      <form method="POST" action="{{ route('transaction.destroy', $transaction->id) }}" class="mt-6 flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
        <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Hapus</button>
      </form>
    </div>
  </div>
</div>
@endsection
