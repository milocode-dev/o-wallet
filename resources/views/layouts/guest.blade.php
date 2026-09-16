<!doctype html>
<html lang="id">
<head>
  @include('layouts.partials.head')
</head>
<body class="min-h-screen bg-forest-50 font-body text-forest-900 antialiased flex items-center justify-center p-4">

  <div class="w-full max-w-sm">
    <div class="flex items-center justify-center gap-2 mb-6">
      <div class="w-9 h-9 rounded-xl bg-forest-700 flex items-center justify-center shrink-0">
        <x-icon name="logo" class="w-5 h-5 text-white" />
      </div>
      <span class="font-display font-extrabold text-lg tracking-tight text-forest-950">o-wallet</span>
    </div>

    <div class="bg-white rounded-2xl border border-forest-100 p-6 md:p-8">
      @yield('content')
    </div>
  </div>

</body>
</html>
