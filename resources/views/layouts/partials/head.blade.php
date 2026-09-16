<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'o-wallet')</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Alpine.js untuk interaksi modal (tanpa perlu build step tambahan) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
