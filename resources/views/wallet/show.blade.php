<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Wallet Page</title>
    @vite(['resources/css/app.css', 'resources/js.app.js'])
</head>
<body>
    <h1>Data wallet untuk wallet, {{ $wallet->wallet_name }}.</h1>
    <a href="{{ route('wallet.edit', $wallet->id) }}" class="border cursor-pointer">Edit</a>
    <p>Berikut adalah detailnya</p>
    <p>{{ $wallet->type }}</p>
    <p>{{ $wallet->nominal }}</p>
    <button>Tambah Saldo</button>
    <button>Transfer</button>

    <form action="{{ route('wallet.destroy', $wallet->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus dompet</button>
    </form>

    <p>Tampilan transaksi dari dompet tersebut</p>
</body>
</html>