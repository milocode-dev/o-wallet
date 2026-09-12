<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Category Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <label for="name" class="block">Nama Kategori</label>
        <input type="text" name="name" class="border" id="name" value="{{ old('name', $category->name) }}">

        <label for="type" class="block">Tipe Kategori</label>
        <select name="type" id="type">
            @foreach ($categoryType as $value => $label)
                <option value="{{ $value }}" {{ old('type', $category->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="cursor-pointer border block">Update data</button>
    </form>
</body>
</html>