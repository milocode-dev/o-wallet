@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ deleteOpen: false, targetName: '', targetAction: '' }">
  <div class="flex items-center justify-between gap-4 flex-wrap">
    <div>
      <h1 class="font-display text-2xl font-bold text-forest-950">Kategori</h1>
      <p class="mt-1 text-forest-600 text-sm">Kelola kategori pemasukan dan pengeluaranmu.</p>
    </div>
    <a href="{{ route('category.create') }}"
       class="rounded-xl bg-forest-700 text-white text-sm font-semibold px-4 py-2.5 hover:bg-forest-600 transition-colors flex items-center gap-1.5">
      <x-icon name="plus" class="w-4 h-4" />
      Tambah Kategori
    </a>
  </div>

  <div class="mt-6 bg-white rounded-2xl border border-forest-100 overflow-hidden">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-forest-50 text-forest-500 text-left">
          <th class="px-5 py-3 font-medium">Kategori</th>
          <th class="px-5 py-3 font-medium">Tipe</th>
          <th class="px-5 py-3 font-medium text-right">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-forest-100">
        @forelse ($categories as $category)
          @php $isIncome = $category->type === 'income'; @endphp
          <tr>
            <td class="px-5 py-3.5">
              <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full {{ $isIncome ? 'bg-forest-500' : 'bg-clay-500' }}"></span>
                {{ $category->name }}
              </div>
            </td>
            <td class="px-5 py-3.5">
              <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $isIncome ? 'bg-forest-100 text-forest-700' : 'bg-clay-50 text-clay-600' }}">
                {{ $isIncome ? 'Pemasukan' : 'Pengeluaran' }}
              </span>
            </td>
            <td class="px-5 py-3.5 text-right space-x-1">
              <a href="{{ route('category.edit', $category->id) }}"
                 class="inline-flex w-8 h-8 rounded-lg items-center justify-center text-forest-500 hover:bg-forest-50 hover:text-forest-700">
                <x-icon name="pencil" class="w-4 h-4" />
              </a>
              <button type="button"
                      @click="deleteOpen = true; targetName = '{{ addslashes($category->name) }}'; targetAction = '{{ route('category.destroy', $category->id) }}'"
                      class="inline-flex w-8 h-8 rounded-lg items-center justify-center text-forest-500 hover:bg-clay-50 hover:text-clay-600">
                <x-icon name="trash" class="w-4 h-4" />
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-5 py-8 text-center text-forest-500">Belum ada kategori. Tambahkan kategori pertamamu.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    </div>
  </div>

  {{-- Modal: Konfirmasi Hapus (dipakai untuk semua baris) --}}
  <div x-show="deleteOpen" x-cloak @click.self="deleteOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="deleteOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 mx-auto rounded-full bg-clay-50 text-clay-600 flex items-center justify-center">
        <x-icon name="warning" class="w-6 h-6" />
      </div>
      <h3 class="font-display text-lg font-bold text-forest-950 mt-4">Hapus kategori <span x-text="targetName"></span>?</h3>
      <p class="text-sm text-forest-500 mt-1.5">Transaksi yang memakai kategori ini akan menjadi tanpa kategori.</p>

      <form method="POST" :action="targetAction" class="mt-6 flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
        <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Hapus</button>
      </form>
    </div>
  </div>
</div>
@endsection
