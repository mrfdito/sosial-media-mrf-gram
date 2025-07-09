<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'MRF.GRAM') }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-300 min-h-screen font-sans">

    {{-- Navbar --}}
    <nav class="bg-gray-900/70 backdrop-blur-lg border-b border-gray-800 fixed top-0 w-full z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-cyan-400 tracking-wider">
                MRF<span class="text-white">.GRAM</span>
            </a>
            
            @auth
                {{-- Right Menu --}}
                <div class="flex items-center gap-5">
                    <a href="{{ route('profile') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold text-white transition-all duration-200 transform hover:scale-105">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                 <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="text-sm bg-cyan-600 hover:bg-cyan-700 px-4 py-2 rounded-lg font-semibold text-white transition-colors">
                        Register
                    </a>
                </div>
            @endguest
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @yield('content')
    </main>

    <style>
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>

</body>
</html>