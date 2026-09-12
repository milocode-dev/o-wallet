<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Wallet Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.cs'])
</head>
<body>
    <form action="{{ route('wallet.store') }}" method="POST">
        @csrf

        <label for="wallet_name" class="block">Nama Dompet</label>
        <input type="text" id="wallet_name" name="wallet_name" class="border">

        <label for="type" class="block">Type</label>
        <select name="type" id="type">
            @foreach ($walletType as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <label for="nominal" class="block">Nominal</label>
        <input type="number" id="nominal" name="nominal" class="border">

        <button type="submit" class="cursor-pointer border">Tambah data</button>
    </form>
</body>
</html>