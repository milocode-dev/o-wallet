@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-6xl mx-auto">
  <h1 class="font-display text-2xl md:text-3xl font-bold text-forest-950">Dashboard Admin</h1>
  <p class="mt-1.5 text-forest-600">Ringkasan aktivitas seluruh pengguna o-wallet.</p>

  {{-- Kartu statistik --}}
  <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    <div class="rounded-2xl p-5 bg-forest-800 weave relative overflow-hidden">
      <div class="w-10 h-10 rounded-lg bg-white/15 flex items-center justify-center text-white">
        <x-icon name="users" class="w-5 h-5" />
      </div>
      <p class="mt-6 text-xs text-forest-200">Total Pengguna</p>
      <p class="text-2xl font-display font-bold text-white tnum">{{ number_format($totalUsers, 0, ',', '.') }}</p>
      <p class="mt-1 text-xs text-forest-300">{{ number_format($activeUsers, 0, ',', '.') }} aktif</p>
    </div>

    <div class="rounded-2xl p-5 bg-forest-700 weave relative overflow-hidden">
      <div class="w-10 h-10 rounded-lg bg-white/15 flex items-center justify-center text-white">
        <x-icon name="wallet" class="w-5 h-5" />
      </div>
      <p class="mt-6 text-xs text-forest-200">Total Dompet</p>
      <p class="text-2xl font-display font-bold text-white tnum">{{ number_format($totalWallets, 0, ',', '.') }}</p>
    </div>

    <div class="rounded-2xl p-5 bg-forest-600 weave relative overflow-hidden">
      <div class="w-10 h-10 rounded-lg bg-white/15 flex items-center justify-center text-white">
        <x-icon name="tunai" class="w-5 h-5" />
      </div>
      <p class="mt-6 text-xs text-forest-100">Total Saldo Beredar</p>
      <p class="text-2xl font-display font-bold text-white tnum">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
    </div>

    <div class="rounded-2xl p-5 bg-forest-900 weave relative overflow-hidden">
      <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-white">
        <x-icon name="chart" class="w-5 h-5" />
      </div>
      <p class="mt-6 text-xs text-forest-300">Transaksi Hari Ini</p>
      <p class="text-2xl font-display font-bold text-white tnum">{{ number_format($todayTransactionsCount, 0, ',', '.') }}</p>
    </div>

  </div>

  {{-- Aktivitas terbaru --}}
  <div class="mt-8 bg-white rounded-2xl border border-forest-100 p-5 md:p-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-display font-bold text-lg text-forest-950">Aktivitas Terbaru</h2>
      <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-forest-600 hover:text-forest-800">Kelola pengguna &rarr;</a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-forest-500 text-left border-b border-forest-100">
            <th class="py-2.5 pr-4 font-medium">Pengguna</th>
            <th class="py-2.5 pr-4 font-medium">Dompet</th>
            <th class="py-2.5 pr-4 font-medium">Kategori</th>
            <th class="py-2.5 pr-4 font-medium">Tanggal</th>
            <th class="py-2.5 pl-4 font-medium text-right">Nominal</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-forest-100">
          @forelse ($recentTransactions as $trx)
            @php $isIncome = $trx->type === 'income'; @endphp
            <tr>
              <td class="py-3 pr-4 text-forest-800 font-medium">{{ $trx->user->name ?? '-' }}</td>
              <td class="py-3 pr-4 text-forest-600">{{ $trx->wallet->wallet_name ?? '-' }}</td>
              <td class="py-3 pr-4 text-forest-600">{{ $trx->category->name ?? '-' }}</td>
              <td class="py-3 pr-4 text-forest-500">{{ \Illuminate\Support\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y') }}</td>
              <td class="py-3 pl-4 text-right font-semibold tnum {{ $isIncome ? 'text-forest-700' : 'text-clay-600' }}">
                {{ $isIncome ? '+' : '-' }}Rp {{ number_format($trx->nominal, 0, ',', '.') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-8 text-center text-forest-500">Belum ada aktivitas transaksi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
