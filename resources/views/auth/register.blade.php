<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Sosial Media</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">

    <div class="w-full max-w-md p-8 rounded-2xl shadow-xl backdrop-blur-lg bg-white/10 border border-white/20 text-white">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold">Buat Akun Baru</h2>
            <p class="text-sm text-gray-300">Gabung dan mulai posting!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 p-2 rounded text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="name" class="block text-sm mb-1 text-gray-200">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 bg-white/10 border border-white/20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                       placeholder="Nama lengkap">
            </div>

            <div>
                <label for="email" class="block text-sm mb-1 text-gray-200">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 bg-white/10 border border-white/20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                       placeholder="you@example.com">
            </div>

            <div>
                <label for="password" class="block text-sm mb-1 text-gray-200">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 bg-white/10 border border-white/20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                       placeholder="********">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm mb-1 text-gray-200">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-2 bg-white/10 border border-white/20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                       placeholder="********">
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                Daftar
            </button>
        </form>

        <p class="text-sm text-center text-gray-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login di sini</a>
        </p>
    </div>

</body>
</html>
