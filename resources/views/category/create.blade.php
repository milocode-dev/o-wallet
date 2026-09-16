@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-xl mx-auto">
  <a href="{{ route('category.index') }}" class="flex items-center gap-1.5 text-sm text-forest-600 hover:text-forest-800 font-medium mb-6 w-fit">
    <x-icon name="chevron-left" class="w-4 h-4" />
    Batal
  </a>

  <div class="bg-white rounded-2xl border border-forest-100 p-6 md:p-8">
    <h1 class="font-display text-xl font-bold text-forest-950">Tambah Kategori</h1>
    <p class="text-sm text-forest-500 mt-1">Kategori membantu mengelompokkan transaksimu.</p>

    <form method="POST" action="{{ route('category.store') }}" class="mt-6">
      @csrf
      @include('category.partials.form')

      <div class="mt-8 flex gap-3">
        <a href="{{ route('category.index') }}" class="flex-1 text-center rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</a>
        <button type="submit" class="flex-1 rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">Simpan Kategori</button>
      </div>
    </form>
  </div>
</div>
@endsection
