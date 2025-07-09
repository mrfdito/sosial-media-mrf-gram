<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MRF.GRAM</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-300 min-h-screen font-sans">

    <div x-data="{ isFormOpen: false }" @keydown.escape.window="isFormOpen = false">

        {{-- Navbar --}}
        <nav class="bg-gray-900/70 backdrop-blur-lg border-b border-gray-800 fixed top-0 w-full z-20">
            <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-cyan-400 tracking-wider">
                    MRF<span class="text-white">.GRAM</span>
                </a>

                @auth
                    {{-- Search User --}}
                    <div x-data="userSearch()" class="relative w-1/3">
                        <input 
                            type="text" 
                            x-model="query" 
                            @input.debounce.300ms="search" 
                            placeholder="Find a user..." 
                            class="w-full pl-4 pr-4 py-2 rounded-lg bg-gray-800 border border-transparent text-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all"
                        >
                        <div 
                            x-show="results.length > 0" 
                            x-transition
                            class="absolute w-full mt-2 bg-gray-800 border border-gray-700 rounded-lg shadow-xl z-50 max-h-72 overflow-y-auto"
                        >
                            <template x-for="user in results" :key="user.id">
                                <a :href="`/profile/${user.id}`" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-700/50 text-white transition-colors duration-150">
                                    <img :src="user.avatar" class="w-9 h-9 rounded-full border-2 border-gray-600">
                                    <span class="font-medium" x-text="user.name"></span>
                                </a>
                            </template>
                        </div>
                    </div>

                    {{-- Right Menu --}}
                    <div class="flex items-center gap-5">
                        <a href="{{ route('profile') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold text-white transition-all duration-200 transform hover:scale-105">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="pt-28 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 pb-32">
            @forelse ($threats as $threat)
                <article class="bg-gray-800/50 border border-gray-700/80 p-5 rounded-xl shadow-lg">
                    {{-- Header Postingan --}}
                    <header class="flex items-center gap-4">
                        <a href="{{ route('profile.public', $threat->user->id) }}">
                            <img class="w-11 h-11 rounded-full object-cover border-2 border-gray-600"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($threat->user->name) }}&background=0D8ABC&color=fff&size=128&font-size=0.5"
                                 alt="User Avatar">
                        </a>
                        <div>
                            <a href="{{ route('profile.public', $threat->user->id) }}" class="font-bold text-base text-cyan-400 hover:underline">
                                {{ $threat->user->name }}
                            </a>
                            <p class="text-xs text-gray-500 font-mono">{{ $threat->created_at->diffForHumans() }}</p>
                        </div>
                    </header>

                    {{-- Isi Konten --}}
                    <div class="mt-4 pl-[60px] text-gray-300 text-base leading-relaxed">
                        <p>{{ $threat->content }}</p>
                    </div>

                    {{-- Tombol Like & Comment Count --}}
                    <div class="pl-[60px] mt-4 flex items-center gap-6 text-sm text-gray-400">
                        <form action="{{ route('threat.like', $threat->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 {{ $threat->isLikedBy(auth()->user()) ? 'text-cyan-400 font-semibold' : 'text-gray-500 hover:text-cyan-400' }} transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.563 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a2 2 0 00-.8 1.4z" /></svg>
                                <span>{{ $threat->likes->count() }}</span>
                            </button>
                        </form>
                         <div class="flex items-center gap-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" /></svg>
                            <span>{{ $threat->comments->count() }}</span>
                        </div>
                    </div>

                    {{-- Daftar Komentar --}}
                    @if($threat->comments->count() > 0)
                    <div class="pl-[60px] mt-4 pt-4 border-t border-gray-700/50 space-y-3 text-sm text-gray-400">
                        @foreach ($threat->comments as $comment)
                            <div class="flex gap-2">
                               <a href="{{ route('profile.public', $comment->user->id) }}" class="font-semibold text-cyan-400/80 hover:underline flex-shrink-0">{{ $comment->user->name }}</a>
                               <p class="text-gray-400">{{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Form Komentar --}}
                    <div class="pl-[60px] mt-4 pt-4 border-t border-gray-700/50">
                        <form action="{{ route('threat.comment', $threat->id) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1f2937&color=fff&size=96" alt="">
                            <input 
                                type="text" 
                                name="comment" 
                                placeholder="Write a comment..." 
                                class="flex-1 bg-gray-700/80 border border-transparent text-white rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 transition"
                                required>
                            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-full text-sm font-semibold transition-colors">
                                Send
                            </button>
                        </form>
                    </div>
                </article>

            @empty
                <div class="text-center py-24 bg-gray-800/40 border border-dashed border-gray-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <p class="mt-5 text-gray-400 text-lg font-medium">No posts yet.</p>
                    <p class="text-gray-500 text-sm">Be the first to start a discussion.</p>
                </div>
            @endforelse
        </main>

        {{-- Floating Action Buttons --}}
        <div class="fixed bottom-8 right-8 space-y-4">
             <a href="{{ route('chat.users') }}" class="flex items-center justify-center bg-green-600 hover:bg-green-500 text-white rounded-full w-16 h-16 shadow-lg transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-green-500/50" title="Open Chat">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
            <button @click="isFormOpen = true" class="flex items-center justify-center bg-cyan-600 hover:bg-cyan-500 text-white rounded-full w-16 h-16 shadow-lg transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-cyan-500/50" title="Create New Post">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        {{-- Floating Threat Form (Modal) --}}
        <div x-show="isFormOpen" x-cloak
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-30 px-4">

            <div @click.outside="isFormOpen = false"
                 x-show="isFormOpen"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="bg-gray-800 p-6 rounded-2xl w-full max-w-lg relative shadow-2xl border border-gray-700">

                <h3 class="text-xl font-semibold mb-5 text-white">Create a New Post</h3>
                <form method="POST" action="{{ route('threat.store') }}" class="space-y-4">
                    @csrf
                    <textarea name="content" rows="5" class="w-full p-4 bg-gray-900 text-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-shadow" placeholder="What's on your mind?"></textarea>
                    <button type="submit" class="w-full py-3 bg-cyan-600 hover:bg-cyan-700 rounded-lg font-semibold text-white transition-colors duration-200 focus:outline-none focus:ring-4 focus:ring-cyan-500/50">
                        Post
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        [x-cloak] { display: none !important; }
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>

    <script>
        function userSearch() {
            return {
                query: '',
                results: [],
                search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }
                    fetch(`/api/search-users?q=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data.map(user => ({
                                id: user.id,
                                name: user.name,
                                avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=0D8ABC&color=fff&size=96`
                            }));
                        });
                }
            }
        }
    </script>
</body>
</html>