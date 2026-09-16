<!doctype html>
<html lang="id">
<head>
  @include('layouts.partials.head')
</head>
<body class="bg-forest-50 font-body text-forest-900 antialiased">

  {{-- HEADER --}}
  <header class="max-w-6xl mx-auto px-5 md:px-10 py-6 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <div class="w-9 h-9 rounded-xl bg-forest-700 flex items-center justify-center shrink-0">
        <x-icon name="logo" class="w-5 h-5 text-white" />
      </div>
      <span class="font-display font-extrabold text-lg tracking-tight text-forest-950">o-wallet</span>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('login') }}" class="text-sm font-medium text-forest-700 hover:text-forest-900 px-4 py-2">Masuk</a>
      <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-forest-700 hover:bg-forest-600 transition-colors rounded-xl px-4 py-2">Daftar Gratis</a>
    </div>
  </header>

  {{-- HERO --}}
  <section class="max-w-6xl mx-auto px-5 md:px-10 pt-8 md:pt-16 pb-16 md:pb-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    <div>
      <h1 class="font-display text-3xl sm:text-4xl md:text-5xl font-extrabold text-forest-950 leading-tight">
        Catat keuanganmu, dari semua dompet, di satu tempat.
      </h1>
      <p class="mt-5 text-forest-600 text-base md:text-lg">
        o-wallet membantu kamu memantau saldo tunai, rekening bank, dan e-wallet sekaligus —
        lengkap dengan kategori pemasukan/pengeluaran dan riwayat transfer antar dompet.
      </p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('register') }}" class="rounded-xl bg-forest-700 text-white font-semibold text-sm px-6 py-3 hover:bg-forest-600 transition-colors">
          Mulai Sekarang — Gratis
        </a>
        <a href="{{ route('login') }}" class="rounded-xl border border-forest-200 text-forest-700 font-semibold text-sm px-6 py-3 hover:bg-forest-100 transition-colors">
          Saya Sudah Punya Akun
        </a>
      </div>
    </div>

    {{-- Ilustrasi kartu dompet (dekoratif) --}}
    <div class="relative h-64 sm:h-80 lg:h-96">
      <div class="absolute top-6 left-4 right-4 rounded-3xl bg-forest-900 weave p-6 shadow-xl -rotate-3">
        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-white">
          <x-icon name="bank" class="w-6 h-6" />
        </div>
        <p class="mt-8 text-xs text-forest-300">Saldo tersedia</p>
        <p class="text-2xl font-display font-bold text-white tnum">Rp 8.400.000</p>
        <p class="mt-2 text-sm font-medium text-forest-100">BCA</p>
      </div>
      <div class="absolute bottom-2 left-10 right-10 rounded-3xl bg-forest-700 weave p-6 shadow-2xl rotate-2">
        <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-white">
          <x-icon name="e-wallet" class="w-6 h-6" />
        </div>
        <p class="mt-8 text-xs text-forest-200">Saldo tersedia</p>
        <p class="text-2xl font-display font-bold text-white tnum">Rp 620.000</p>
        <p class="mt-2 text-sm font-medium text-forest-100">GoPay</p>
      </div>
    </div>
  </section>

  {{-- FITUR --}}
  <section class="bg-white border-y border-forest-100">
    <div class="max-w-6xl mx-auto px-5 md:px-10 py-14 md:py-20">
      <h2 class="font-display text-2xl md:text-3xl font-bold text-forest-950 text-center">Semua yang kamu butuhkan untuk mencatat keuangan</h2>

      <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl border border-forest-100 p-6">
          <div class="w-11 h-11 rounded-xl bg-forest-100 text-forest-700 flex items-center justify-center">
            <x-icon name="wallet" class="w-5 h-5" />
          </div>
          <h3 class="mt-4 font-display font-bold text-forest-950">Multi-Dompet</h3>
          <p class="mt-1.5 text-sm text-forest-600">Pisahkan uang tunai, rekening bank, dan e-wallet dalam dompet-dompet terpisah, semua terlihat dalam satu dashboard.</p>
        </div>
        <div class="rounded-2xl border border-forest-100 p-6">
          <div class="w-11 h-11 rounded-xl bg-forest-100 text-forest-700 flex items-center justify-center">
            <x-icon name="category" class="w-5 h-5" />
          </div>
          <h3 class="mt-4 font-display font-bold text-forest-950">Kategori Pemasukan & Pengeluaran</h3>
          <p class="mt-1.5 text-sm text-forest-600">Kelompokkan setiap transaksi ke kategori sendiri, jadi kamu tahu persis uangmu datang dari mana dan habis ke mana.</p>
        </div>
        <div class="rounded-2xl border border-forest-100 p-6">
          <div class="w-11 h-11 rounded-xl bg-forest-100 text-forest-700 flex items-center justify-center">
            <x-icon name="arrow-in" class="w-5 h-5" />
          </div>
          <h3 class="mt-4 font-display font-bold text-forest-950">Transfer & Riwayat Transaksi</h3>
          <p class="mt-1.5 text-sm text-forest-600">Pindahkan saldo antar dompet dan pantau seluruh riwayat pemasukan, pengeluaran, serta pembayaran kapan saja.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA BAWAH --}}
  <section class="max-w-6xl mx-auto px-5 md:px-10 py-16 text-center">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-forest-950">Siap rapikan keuanganmu?</h2>
    <p class="mt-2 text-forest-600">Daftar dalam hitungan menit, gratis.</p>
    <a href="{{ route('register') }}" class="mt-6 inline-block rounded-xl bg-forest-700 text-white font-semibold text-sm px-8 py-3.5 hover:bg-forest-600 transition-colors">
      Buat Akun Sekarang
    </a>
  </section>

  {{-- FOOTER --}}
  <footer class="border-t border-forest-100 py-6">
    <p class="text-center text-xs text-forest-400">&copy; {{ date('Y') }} o-wallet. Aplikasi pencatat keuangan pribadi.</p>
  </footer>

</body>
</html>
