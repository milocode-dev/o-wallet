@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="max-w-6xl mx-auto">
  <h1 class="font-display text-2xl md:text-3xl font-bold text-forest-950">Kelola Pengguna</h1>
  <p class="mt-1.5 text-forest-600">Lihat seluruh pengguna terdaftar dan atur status aktifnya.</p>

  <div class="mt-8 bg-white rounded-2xl border border-forest-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-forest-50 text-forest-500 text-left">
            <th class="px-5 py-3 font-medium">Pengguna</th>
            <th class="px-5 py-3 font-medium">Role</th>
            <th class="px-5 py-3 font-medium text-center">Dompet</th>
            <th class="px-5 py-3 font-medium text-center">Transaksi</th>
            <th class="px-5 py-3 font-medium text-right">Total Saldo</th>
            <th class="px-5 py-3 font-medium text-center">Status</th>
            <th class="px-5 py-3 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-forest-100">
          @forelse ($users as $user)
            <tr>
              <td class="px-5 py-3.5 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-forest-700 flex items-center justify-center text-xs font-semibold text-white shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                  <div class="min-w-0">
                    <p class="font-medium text-forest-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-forest-500 truncate">{{ $user->email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-forest-700 text-white' : 'bg-forest-100 text-forest-700' }}">
                  {{ ucfirst($user->role) }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-center text-forest-600 tnum">{{ $user->wallets_count }}</td>
              <td class="px-5 py-3.5 text-center text-forest-600 tnum">{{ $user->transactions_count }}</td>
              <td class="px-5 py-3.5 text-right text-forest-800 font-medium tnum">Rp {{ number_format($user->total_balance ?? 0, 0, ',', '.') }}</td>
              <td class="px-5 py-3.5 text-center">
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-forest-100 text-forest-700' : 'bg-clay-50 text-clay-600' }}">
                  {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-right">
                @if ($user->id === auth()->id())
                  <span class="text-xs text-forest-400">Akun Anda</span>
                @else
                  <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors
                                   {{ $user->is_active ? 'text-clay-600 hover:bg-clay-50' : 'text-forest-700 hover:bg-forest-50' }}">
                      {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-8 text-center text-forest-500">Belum ada pengguna terdaftar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-6">
    {{ $users->links() }}
  </div>
</div>
@endsection
