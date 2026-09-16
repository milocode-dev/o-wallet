@php
  $isEdit = isset($category);
  $displayLabels = ['income' => 'Pemasukan', 'expense' => 'Pengeluaran'];
  $selectedType = old('type', $category->type ?? array_key_first($categoryType));
@endphp

<div>
  <label for="name" class="block text-sm font-medium text-forest-800 mb-1.5">Nama kategori</label>
  <input type="text" name="name" id="name" placeholder="Contoh: Langganan Streaming"
         value="{{ old('name', $category->name ?? '') }}"
         class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
  @error('name')
    <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
  @enderror
</div>

<div class="mt-5">
  <label class="block text-sm font-medium text-forest-800 mb-1.5">Tipe</label>
  <div class="grid grid-cols-2 gap-2">
    @foreach (array_keys($categoryType) as $value)
      {{-- Tambahkan w-full agar ukurannya pas di dalam grid --}}
      <div class="relative w-full">
        <input type="radio" name="type" id="ct-{{ $value }}" value="{{ $value }}" class="peer hidden"
               @checked($selectedType == $value)>
               
        <label for="ct-{{ $value }}"
               class="cursor-pointer block text-center rounded-xl border border-forest-150 py-2.5 text-forest-700 text-sm font-medium transition-colors peer-checked:bg-forest-700 peer-checked:text-white peer-checked:border-forest-700">
          {{ $displayLabels[$value] ?? $categoryType[$value] }}
        </label>
      </div>
    @endforeach
  </div>
  @error('type')
    <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
  @enderror
</div>