@php
  $bgVariants = ['bg-forest-700', 'bg-forest-800', 'bg-forest-600', 'bg-forest-900'];
  $bg = $bgVariants[$loop->index % count($bgVariants)];
@endphp

<a href="{{ route('wallet.show', $wallet->id) }}"
   class="group text-left rounded-2xl p-5 {{ $bg }} weave relative overflow-hidden transition-transform hover:-translate-y-0.5 focus-visible:-translate-y-0.5 block">
  <div class="flex items-center justify-between">
    <div class="w-10 h-10 rounded-lg bg-white/15 flex items-center justify-center text-white">
      <x-icon :name="$wallet->type" class="w-5 h-5" />
    </div>
    <x-icon name="chevron-right" class="w-4 h-4 text-white/50" />
  </div>
  <p class="mt-6 text-xs text-forest-200">Saldo tersedia</p>
  <p class="text-xl font-display font-bold text-white tnum">Rp {{ number_format($wallet->nominal, 0, ',', '.') }}</p>
  <p class="mt-3 text-sm font-medium text-forest-100">{{ $wallet->wallet_name }}</p>
</a>
