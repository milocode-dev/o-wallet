@php
  $isEdit = isset($wallet);
  $selectedType = old('type', $wallet->type ?? array_key_first($walletType));
@endphp

<div>
  <label for="wallet_name" class="block text-sm font-medium text-forest-800 mb-1.5">Nama dompet</label>
  <input type="text" name="wallet_name" id="wallet_name" placeholder="Contoh: Tabungan Liburan"
         value="{{ old('wallet_name', $wallet->wallet_name ?? '') }}"
         class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
  @error('wallet_name')
    <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
  @enderror
</div>

<div class="mt-5">
  <label class="block text-sm font-medium text-forest-800 mb-1.5">Jenis dompet</label>
  <div class="grid grid-cols-3 gap-2">
    @foreach ($walletType as $value => $label)
      <div class="relative">
        <input type="radio" name="type" id="wt-{{ $value }}" value="{{ $value }}" class="peer hidden"
             @checked($selectedType == $value)>
        <label for="wt-{{ $value }}"
              class="cursor-pointer rounded-xl border border-forest-150 py-2.5 flex flex-col items-center gap-1 text-forest-700 text-xs font-medium transition-colors peer-checked:bg-forest-700 peer-checked:text-white peer-checked:border-forest-700">
          <x-icon :name="$value" class="w-4.5 h-4.5" />
          {{ $label }}
        </label>
      </div>
    @endforeach
  </div>
  @error('type')
    <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
  @enderror
</div>

<div class="mt-5">
  <label for="nominal" class="block text-sm font-medium text-forest-800 mb-1.5">
    {{ $isEdit ? 'Saldo saat ini' : 'Saldo awal' }}
  </label>
  <div class="relative">
    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-forest-400">Rp</span>
    <input type="number" min="0" step="1" name="nominal" id="nominal" placeholder="0"
           value="{{ old('nominal', $wallet->nominal ?? '') }}"
           class="w-full rounded-xl border border-forest-150 pl-10 pr-3.5 py-2.5 text-sm tnum focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
  </div>
  @error('nominal')
    <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
  @enderror
</div>
