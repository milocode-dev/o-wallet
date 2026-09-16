<!doctype html>
<html lang="id">
<head>
  @include('layouts.partials.head')
</head>
<body class="bg-forest-50 font-body text-forest-900 antialiased">

@php
  $adminNavItems = [
    ['route' => 'dashboard.admin',    'pattern' => 'dashboard.admin',    'icon' => 'dashboard', 'label' => 'Dashboard'],
    ['route' => 'admin.users.index',  'pattern' => 'admin.users.*',      'icon' => 'users',     'label' => 'Pengguna'],
  ];
@endphp

{{-- TOP BAR (mobile only) --}}
<header class="md:hidden flex items-center justify-between px-4 py-3 bg-forest-950 text-white sticky top-0 z-30">
  <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2">
    <div class="w-8 h-8 rounded-lg bg-forest-500 flex items-center justify-center shrink-0">
      <x-icon name="logo" class="w-4 h-4 text-forest-950" />
    </div>
    <span class="font-display font-extrabold text-base tracking-tight">o-wallet <span class="font-normal text-forest-400 text-xs">Admin</span></span>
  </a>
  <div class="w-8 h-8 rounded-full bg-forest-700 flex items-center justify-center text-xs font-semibold">
    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
  </div>
</header>

<div class="flex min-h-screen">

  {{-- SIDEBAR (desktop only) --}}
  <aside class="hidden md:flex md:w-64 shrink-0 bg-forest-950 text-forest-100 flex-col py-6 px-5">
    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2 px-2 mb-2">
      <div class="w-9 h-9 rounded-xl bg-forest-500 flex items-center justify-center shrink-0">
        <x-icon name="logo" class="w-5 h-5 text-forest-950" />
      </div>
      <span class="font-display font-extrabold text-lg tracking-tight text-white">o-wallet</span>
    </a>
    <p class="px-2 mb-8 text-xs font-medium text-forest-400">Panel Admin</p>

    <nav class="flex flex-col gap-1">
      @foreach ($adminNavItems as $item)
        @php $active = request()->routeIs($item['pattern']); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                  {{ $active ? 'bg-forest-700 text-white' : 'text-forest-300 hover:bg-forest-800 hover:text-white' }}">
          <x-icon :name="$item['icon']" class="w-5 h-5 shrink-0" />
          <span>{{ $item['label'] }}</span>
        </a>
      @endforeach

      <a href="{{ route('wallet.index') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-forest-300 hover:bg-forest-800 hover:text-white">
        <x-icon name="wallet" class="w-5 h-5 shrink-0" />
        <span>Aplikasi User</span>
      </a>
    </nav>

    <div class="mt-auto pt-6 border-t border-forest-800">
      <div class="flex items-center gap-3 px-2 mb-3">
        <div class="w-9 h-9 rounded-full bg-forest-700 flex items-center justify-center text-sm font-semibold text-white shrink-0">
          {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="leading-tight min-w-0">
          <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
          <p class="text-xs text-forest-400 truncate">Administrator</p>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-medium text-forest-300 hover:bg-forest-800 hover:text-white transition-colors">
          <x-icon name="logout" class="w-4 h-4" />
          Keluar
        </button>
      </form>
    </div>
  </aside>

  {{-- MAIN --}}
  <main class="flex-1 min-w-0 px-4 py-5 pb-24 md:p-10 md:pb-10">
    @if (session('success'))
      <div class="max-w-6xl mx-auto mb-6 rounded-xl bg-forest-100 text-forest-700 text-sm font-medium px-4 py-3">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="max-w-6xl mx-auto mb-6 rounded-xl bg-clay-50 text-clay-700 text-sm font-medium px-4 py-3">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>
</div>

{{-- BOTTOM TAB BAR (mobile only) --}}
<nav class="md:hidden fixed bottom-0 inset-x-0 z-30 bg-forest-950 border-t border-forest-800 flex items-stretch">
  @foreach ($adminNavItems as $item)
    @php $active = request()->routeIs($item['pattern']); @endphp
    <a href="{{ route($item['route']) }}"
       class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 text-[11px] font-medium {{ $active ? 'text-white' : 'text-forest-400' }}">
      <x-icon :name="$item['icon']" class="w-5 h-5" />
      {{ $item['label'] }}
    </a>
  @endforeach

  <a href="{{ route('wallet.index') }}"
     class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 text-[11px] font-medium text-forest-400">
    <x-icon name="wallet" class="w-5 h-5" />
    User
  </a>

  <form method="POST" action="{{ route('logout') }}" class="flex-1">
    @csrf
    <button type="submit" class="w-full h-full flex flex-col items-center justify-center gap-1 py-2.5 text-[11px] font-medium text-forest-400">
      <x-icon name="logout" class="w-5 h-5" />
      Keluar
    </button>
  </form>
</nav>

</body>
</html>
