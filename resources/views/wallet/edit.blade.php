<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Wallet Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div>
        <form action="{{ route('wallet.update', $wallet->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="wallet_name" class="block">Nama Dompet</label>
        <input type="text" id="wallet_name" name="wallet_name" class="border" value="{{ old('wallet_name', $wallet->wallet_name) }}">

        <label for="type" class="block">Type</label>
        <select name="type" id="type">
            @foreach ($walletType as $value => $label)
                <option value="{{ $value }}" {{ old('type', $wallet->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <label for="nominal" class="block">Nominal</label>
        <input type="number" id="nominal" name="nominal" class="border" value="{{ old('nominal', $wallet->nominal) }}">

        <button type="submit" class="cursor-pointer border">Edit data</button>
    </form>
    </div>
</body>
</html>