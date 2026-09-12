<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category Page</title>
    @vite(['resource/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="{{ route('category.create') }}">+ Tambah data</a>
    <table border 1>
        <tr>
            <th>Nama Kategori</th>
            <th>Tipe Kategori</th>
            <th>Aksi</th>
        </tr>

        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->type }}</td>
                <td>
                    <a href="{{ route('category.edit', $category->id) }}" class="border">Edit</a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>