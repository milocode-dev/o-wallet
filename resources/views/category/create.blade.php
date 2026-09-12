<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Category Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <label for="name" class="block">Nama Kategori</label>
        <input type="text" name="name" class="border" id="name">

        <label for="type" class="block">Tipe Kategori</label>
        <select name="type" id="type">
            @foreach ($categoryType as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="cursor-pointer border block">Add data</button>
    </form>
</body>
</html>