<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex justify-center items-center">
    <div>
        <div>
            <h1>Welcome to user dashboard, {{ $user->name }}</h1>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="p-1 border mb-2 cursor-pointer rounded-md">Logout</button>
        </form>

        <div class="flex gap-2">
            @foreach ($wallets as $wallet)
                <a href="{{ route('wallet.show', $wallet->id) }}">
                    <div class="w-25 border rounded-md p-1.5">
                        <h1>{{ $wallet->wallet_name }}</h1>
                        <p>{{ $wallet->type }}</p>
                        <p>{{ $wallet->nominal }}</p>
                    </div>
                </a>
            @endforeach

            <a href="{{ route('wallet.create') }}">
                <div class="w-25 border rounded-md p-1.5">
                    <h1>Logo Tambah</h1>
                    <p>Tambah dompet?</p>
                    <p>Text</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>