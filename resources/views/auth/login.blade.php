<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex justify-center items-center bg-gray-100">
    <main class="rounded-xl shadow-2xl bg-white">
        <div class="p-4">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Selamat Datang!</h1>
                <p class="font-light text-slate-500">Masuk dengan akun pengguna.</p>
            </div>

            @if (@session('error'))
                <div class="text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.action') }}">
                @csrf 

                <div class="mb-2">
                    <label for="email" class="block text-slate-700 font-bold">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Isi e-mail anda" class="focus:outline-none border-b w-full p-1">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-slate-700 font-bold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Isi password anda" class="focus:outline-none border-b w-full p-1">
                </div>

                <div>
                    <button type="submit" class="cursor-pointer bg-emerald-700 text-white p-1.5 rounded-md w-20">Login</button>
                    <a href="{{ route('register') }}" class="text-blue-400"> <span class="text-black">Belum punya akun?</span> Daftar sekarang!</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>