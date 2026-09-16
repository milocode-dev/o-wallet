@extends('layouts.app')

@section('title', $wallet->wallet_name)

@section('content')
<div class="max-w-6xl mx-auto"
     x-data="{
        topupOpen: {{ old('_form') === 'topup' ? 'true' : 'false' }},
        payOpen: {{ old('_form') === 'pay' ? 'true' : 'false' }},
        transferOpen: {{ old('_form') === 'transfer' ? 'true' : 'false' }},
        deleteWalletOpen: false,
        deleteTrxOpen: false,
        trxName: '',
        trxAction: ''
     }">

  <a href="{{ route('wallet.index') }}" class="flex items-center gap-1.5 text-sm text-forest-600 hover:text-forest-800 font-medium mb-6 w-fit">
    <x-icon name="chevron-left" class="w-4 h-4" />
    Kembali ke Dashboard
  </a>

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- Card besar + aksi --}}
    <div class="lg:col-span-2">
      <div class="rounded-3xl bg-forest-800 weave p-7 text-center relative">
        <a href="{{ route('wallet.edit', $wallet->id) }}"
           class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors"
           title="Edit dompet">
          <x-icon name="pencil" class="w-4 h-4" />
        </a>

        <div class="w-16 h-16 mx-auto rounded-2xl bg-white/15 flex items-center justify-center text-white">
          <x-icon :name="$wallet->type" class="w-8 h-8" />
        </div>

        <p class="mt-4 font-display text-xl font-bold text-white">{{ $wallet->wallet_name }}</p>
        <p class="mt-1 text-xs uppercase tracking-wide text-forest-300">Saldo tersedia</p>
        <p class="text-3xl font-display font-extrabold text-white tnum">Rp {{ number_format($wallet->nominal, 0, ',', '.') }}</p>

        <div class="mt-6 grid grid-cols-3 gap-2">
          <button type="button" @click="topupOpen = true"
                  class="bg-white text-forest-800 font-semibold text-xs sm:text-sm rounded-xl py-2.5 px-1 hover:bg-forest-100 transition-colors">
            Tambah Saldo
          </button>
          <button type="button" @click="payOpen = true"
                  class="bg-white/10 text-white font-semibold text-xs sm:text-sm rounded-xl py-2.5 px-1 hover:bg-white/20 transition-colors border border-white/20">
            Bayar
          </button>
          <button type="button" @click="transferOpen = true"
                  class="bg-white/10 text-white font-semibold text-xs sm:text-sm rounded-xl py-2.5 px-1 hover:bg-white/20 transition-colors border border-white/20">
            Transfer
          </button>
        </div>
      </div>

      <button type="button" @click="deleteWalletOpen = true"
              class="mt-4 w-full text-center text-sm text-clay-600 hover:text-clay-700 font-medium py-2">
        Hapus dompet ini
      </button>
    </div>

    {{-- Riwayat transaksi --}}
    <div class="lg:col-span-3 bg-white rounded-2xl border border-forest-100 p-5 md:p-6">
      <h2 class="font-display font-bold text-lg text-forest-950 mb-4">Riwayat Transaksi</h2>

      <ul class="divide-y divide-forest-100">
        @forelse ($transactions as $trx)
          @php
            $isIncome = $trx->type === 'income';
            $isTransfer = $trx->transfer_pair_id !== null;
            $subLabel = $trx->category->name ?? ($isTransfer ? ($isIncome ? 'Transfer Masuk' : 'Transfer Keluar') : ($isIncome ? 'Pemasukan' : 'Pengeluaran'));
          @endphp
          <li class="py-3.5 flex items-center gap-2 sm:gap-3">
            <div class="w-9 h-9 rounded-full {{ $isIncome ? 'bg-forest-100 text-forest-600' : 'bg-clay-50 text-clay-600' }} flex items-center justify-center shrink-0">
              <x-icon :name="$isIncome ? 'arrow-in' : 'arrow-out'" class="w-4.5 h-4.5" />
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-medium text-forest-900 truncate">{{ $trx->name }}</p>
              <p class="text-xs text-forest-500 truncate">{{ $subLabel }} &middot; {{ \Illuminate\Support\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y') }}</p>
            </div>
            <p class="text-sm font-semibold tnum shrink-0 {{ $isIncome ? 'text-forest-700' : 'text-clay-600' }}">
              {{ $isIncome ? '+' : '-' }}Rp {{ number_format($trx->nominal, 0, ',', '.') }}
            </p>
            <div class="flex items-center gap-0.5 shrink-0">
              @if (!$isTransfer)
                <a href="{{ route('transaction.edit', $trx->id) }}"
                   class="inline-flex w-7 h-7 rounded-lg items-center justify-center text-forest-400 hover:bg-forest-50 hover:text-forest-700">
                  <x-icon name="pencil" class="w-3.5 h-3.5" />
                </a>
              @endif
              <button type="button"
                      @click="deleteTrxOpen = true; trxName = '{{ addslashes($trx->name) }}'; trxAction = '{{ route('transaction.destroy', $trx->id) }}'"
                      class="inline-flex w-7 h-7 rounded-lg items-center justify-center text-forest-400 hover:bg-clay-50 hover:text-clay-600">
                <x-icon name="trash" class="w-3.5 h-3.5" />
              </button>
            </div>
          </li>
        @empty
          <li class="py-8 text-center text-sm text-forest-500">Belum ada transaksi pada dompet ini.</li>
        @endforelse
      </ul>
    </div>
  </div>

  {{-- Modal: Tambah Saldo --}}
  <div x-show="topupOpen" x-cloak @click.self="topupOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="topupOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between">
        <div>
          <h3 class="font-display text-lg font-bold text-forest-950">Tambah Saldo</h3>
          <p class="text-sm text-forest-500 mt-0.5">Masukkan nominal untuk <span class="font-medium text-forest-700">{{ $wallet->wallet_name }}</span></p>
        </div>
        <button type="button" @click="topupOpen = false" class="w-8 h-8 rounded-lg flex items-center justify-center text-forest-400 hover:bg-forest-50 hover:text-forest-600 shrink-0">
          <x-icon name="close" class="w-4 h-4" />
        </button>
      </div>

      <form method="POST" action="{{ route('transaction.store') }}" class="mt-5 space-y-4">
        @csrf
        <input type="hidden" name="_form" value="topup">
        <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
        <input type="hidden" name="type" value="income">

        <div>
          <label for="topup_name" class="block text-sm font-medium text-forest-800 mb-1.5">Catatan</label>
          <input type="text" name="name" id="topup_name" required placeholder="Contoh: Gajian bulan ini"
                 value="{{ old('_form') === 'topup' ? old('name') : '' }}"
                 class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          @error('name') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="topup_amount" class="block text-sm font-medium text-forest-800 mb-1.5">Nominal</label>
          <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-forest-400">Rp</span>
            <input type="number" min="1" step="1" name="nominal" id="topup_amount" required placeholder="0"
                   value="{{ old('_form') === 'topup' ? old('nominal') : '' }}"
                   class="w-full rounded-xl border border-forest-150 pl-10 pr-3.5 py-2.5 text-sm tnum focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          </div>
          @error('nominal') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="topup_category" class="block text-sm font-medium text-forest-800 mb-1.5">Kategori</label>
          <select name="category_id" id="topup_category" required
                  class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm text-forest-800 focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">
            <option value="" disabled selected>Pilih kategori pemasukan</option>
            @foreach ($incomeCategories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          @if ($incomeCategories->isEmpty())
            <p class="mt-1.5 text-xs text-forest-500">Kamu belum punya kategori pemasukan. <a href="{{ route('category.create') }}" class="underline">Tambah dulu di sini</a>.</p>
          @endif
        </div>

        <div>
          <label for="topup_date" class="block text-sm font-medium text-forest-800 mb-1.5">Tanggal</label>
          <input type="date" name="transaction_date" id="topup_date" required
                 value="{{ old('_form') === 'topup' ? old('transaction_date', now()->format('Y-m-d')) : now()->format('Y-m-d') }}"
                 class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          @error('transaction_date') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="topup_desc" class="block text-sm font-medium text-forest-800 mb-1.5">Deskripsi <span class="text-forest-400 font-normal">(opsional)</span></label>
          <textarea name="description" id="topup_desc" rows="2"
                    class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">{{ old('_form') === 'topup' ? old('description') : '' }}</textarea>
        </div>

        <div class="flex gap-3 pt-1">
          <button type="button" @click="topupOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
          <button type="submit" class="flex-1 rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Bayar --}}
  <div x-show="payOpen" x-cloak @click.self="payOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="payOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between">
        <div>
          <h3 class="font-display text-lg font-bold text-forest-950">Bayar</h3>
          <p class="text-sm text-forest-500 mt-0.5">Catat pengeluaran dari <span class="font-medium text-forest-700">{{ $wallet->wallet_name }}</span></p>
        </div>
        <button type="button" @click="payOpen = false" class="w-8 h-8 rounded-lg flex items-center justify-center text-forest-400 hover:bg-forest-50 hover:text-forest-600 shrink-0">
          <x-icon name="close" class="w-4 h-4" />
        </button>
      </div>

      <form method="POST" action="{{ route('transaction.store') }}" class="mt-5 space-y-4">
        @csrf
        <input type="hidden" name="_form" value="pay">
        <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
        <input type="hidden" name="type" value="expense">

        <div>
          <label for="pay_name" class="block text-sm font-medium text-forest-800 mb-1.5">Catatan</label>
          <input type="text" name="name" id="pay_name" required placeholder="Contoh: Bayar listrik"
                 value="{{ old('_form') === 'pay' ? old('name') : '' }}"
                 class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          @error('name') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="pay_amount" class="block text-sm font-medium text-forest-800 mb-1.5">Nominal</label>
          <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-forest-400">Rp</span>
            <input type="number" min="1" step="1" max="{{ (int) $wallet->nominal }}" name="nominal" id="pay_amount" required placeholder="0"
                   value="{{ old('_form') === 'pay' ? old('nominal') : '' }}"
                   class="w-full rounded-xl border border-forest-150 pl-10 pr-3.5 py-2.5 text-sm tnum focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          </div>
          <p class="mt-1.5 text-xs text-forest-400">Saldo tersedia: Rp {{ number_format($wallet->nominal, 0, ',', '.') }}</p>
          @error('nominal') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="pay_category" class="block text-sm font-medium text-forest-800 mb-1.5">Kategori</label>
          <select name="category_id" id="pay_category" required
                  class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm text-forest-800 focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">
            <option value="" disabled selected>Pilih kategori pengeluaran</option>
            @foreach ($expenseCategories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          @if ($expenseCategories->isEmpty())
            <p class="mt-1.5 text-xs text-forest-500">Kamu belum punya kategori pengeluaran. <a href="{{ route('category.create') }}" class="underline">Tambah dulu di sini</a>.</p>
          @endif
        </div>

        <div>
          <label for="pay_date" class="block text-sm font-medium text-forest-800 mb-1.5">Tanggal</label>
          <input type="date" name="transaction_date" id="pay_date" required
                 value="{{ old('_form') === 'pay' ? old('transaction_date', now()->format('Y-m-d')) : now()->format('Y-m-d') }}"
                 class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
          @error('transaction_date') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="pay_desc" class="block text-sm font-medium text-forest-800 mb-1.5">Deskripsi <span class="text-forest-400 font-normal">(opsional)</span></label>
          <textarea name="description" id="pay_desc" rows="2"
                    class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">{{ old('_form') === 'pay' ? old('description') : '' }}</textarea>
        </div>

        <div class="flex gap-3 pt-1">
          <button type="button" @click="payOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
          <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Bayar</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Transfer --}}
  <div x-show="transferOpen" x-cloak @click.self="transferOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="transferOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 max-h-[90vh] overflow-y-auto">
      <div class="flex items-start justify-between">
        <div>
          <h3 class="font-display text-lg font-bold text-forest-950">Transfer Dana</h3>
          <p class="text-sm text-forest-500 mt-0.5">Kirim saldo dari <span class="font-medium text-forest-700">{{ $wallet->wallet_name }}</span> ke dompet lain</p>
        </div>
        <button type="button" @click="transferOpen = false" class="w-8 h-8 rounded-lg flex items-center justify-center text-forest-400 hover:bg-forest-50 hover:text-forest-600 shrink-0">
          <x-icon name="close" class="w-4 h-4" />
        </button>
      </div>

      @if ($allWallet->isEmpty())
        <p class="mt-5 text-sm text-forest-500">Kamu perlu minimal satu dompet lain untuk bisa transfer. <a href="{{ route('wallet.create') }}" class="underline">Tambah dompet baru</a>.</p>
      @else
        <form method="POST" action="{{ route('transaction.transfer') }}" class="mt-5 space-y-4">
          @csrf
          <input type="hidden" name="_form" value="transfer">
          <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
          <input type="hidden" name="type" value="transfer">

          <div>
            <label for="transfer_name" class="block text-sm font-medium text-forest-800 mb-1.5">Catatan</label>
            <input type="text" name="name" id="transfer_name" required placeholder="Contoh: Transfer ke tabungan"
                   value="{{ old('_form') === 'transfer' ? old('name') : '' }}"
                   class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
            @error('name') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="transfer_to" class="block text-sm font-medium text-forest-800 mb-1.5">Transfer ke</label>
            <select name="to_wallet_id" id="transfer_to" required
                    class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm text-forest-800 focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">
              @foreach ($allWallet as $ow)
                <option value="{{ $ow->id }}">{{ $ow->wallet_name }}</option>
              @endforeach
            </select>
            @error('to_wallet_id') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="transfer_amount" class="block text-sm font-medium text-forest-800 mb-1.5">Nominal</label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-forest-400">Rp</span>
              <input type="number" min="1" step="1" max="{{ (int) $wallet->nominal }}" name="nominal" id="transfer_amount" required placeholder="0"
                     value="{{ old('_form') === 'transfer' ? old('nominal') : '' }}"
                     class="w-full rounded-xl border border-forest-150 pl-10 pr-3.5 py-2.5 text-sm tnum focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
            </div>
            <p class="mt-1.5 text-xs text-forest-400">Saldo tersedia: Rp {{ number_format($wallet->nominal, 0, ',', '.') }}</p>
            @error('nominal') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="transfer_date" class="block text-sm font-medium text-forest-800 mb-1.5">Tanggal</label>
            <input type="date" name="transaction_date" id="transfer_date" required
                   value="{{ old('_form') === 'transfer' ? old('transaction_date', now()->format('Y-m-d')) : now()->format('Y-m-d') }}"
                   class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none" />
            @error('transaction_date') <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="transfer_desc" class="block text-sm font-medium text-forest-800 mb-1.5">Deskripsi <span class="text-forest-400 font-normal">(opsional)</span></label>
            <textarea name="description" id="transfer_desc" rows="2"
                      class="w-full rounded-xl border border-forest-150 px-3.5 py-2.5 text-sm focus:border-forest-500 focus:ring-1 focus:ring-forest-500 outline-none">{{ old('_form') === 'transfer' ? old('description') : '' }}</textarea>
          </div>

          @error('to_wallet_id')
            <p class="text-xs text-clay-600">{{ $message }}</p>
          @enderror

          <div class="flex gap-3 pt-1">
            <button type="button" @click="transferOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
            <button type="submit" class="flex-1 rounded-xl bg-forest-700 text-white font-semibold text-sm py-2.5 hover:bg-forest-600 transition-colors">Kirim</button>
          </div>
        </form>
      @endif
    </div>
  </div>

  {{-- Modal: Konfirmasi Hapus Dompet --}}
  <div x-show="deleteWalletOpen" x-cloak @click.self="deleteWalletOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="deleteWalletOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 mx-auto rounded-full bg-clay-50 text-clay-600 flex items-center justify-center">
        <x-icon name="warning" class="w-6 h-6" />
      </div>
      <h3 class="font-display text-lg font-bold text-forest-950 mt-4">Hapus dompet ini?</h3>
      <p class="text-sm text-forest-500 mt-1.5">Seluruh riwayat transaksi pada dompet ini akan ikut terhapus dan tidak bisa dikembalikan.</p>

      <form method="POST" action="{{ route('wallet.destroy', $wallet->id) }}" class="mt-6 flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteWalletOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
        <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Hapus</button>
      </form>
    </div>
  </div>

  {{-- Modal: Konfirmasi Hapus Transaksi --}}
  <div x-show="deleteTrxOpen" x-cloak @click.self="deleteTrxOpen = false"
       class="fixed inset-0 z-40 flex items-center justify-center bg-forest-950/40 backdrop-blur-sm p-4">
    <div x-show="deleteTrxOpen" x-transition class="bg-white rounded-2xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 mx-auto rounded-full bg-clay-50 text-clay-600 flex items-center justify-center">
        <x-icon name="warning" class="w-6 h-6" />
      </div>
      <h3 class="font-display text-lg font-bold text-forest-950 mt-4">Hapus transaksi <span x-text="trxName"></span>?</h3>
      <p class="text-sm text-forest-500 mt-1.5">Saldo dompet akan disesuaikan kembali secara otomatis.</p>

      <form method="POST" :action="trxAction" class="mt-6 flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteTrxOpen = false" class="flex-1 rounded-xl border border-forest-150 text-forest-700 font-medium text-sm py-2.5 hover:bg-forest-50 transition-colors">Batal</button>
        <button type="submit" class="flex-1 rounded-xl bg-clay-600 text-white font-semibold text-sm py-2.5 hover:bg-clay-700 transition-colors">Hapus</button>
      </form>
    </div>
  </div>

</div>
@endsection
