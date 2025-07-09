@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Main Profile Card --}}
    <div class="bg-gray-800/50 border border-gray-700/80 rounded-xl shadow-lg overflow-hidden">
        
        {{-- Profile Header Section (Banner & Avatar) --}}
        <div>
            {{-- Banner Image --}}
            <div class="h-40 bg-gradient-to-r from-cyan-900/50 via-gray-900 to-slate-800/50"></div>

            <div class="px-6 pb-6 -mt-20">
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-5">
                    
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <img class="w-32 h-32 rounded-full object-cover border-4 border-gray-800 shadow-md" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=256&font-size=0.4&bold=true" 
                             alt="Avatar of {{ $user->name }}">
                    </div>
                    
                    <div class="flex-grow pt-20 w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                            {{-- Name and Email --}}
                            <div class="text-center sm:text-left">
                                <h2 class="text-3xl font-bold text-white tracking-tight">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-400 mt-1">{{ $user->email }}</p>
                            </div>

                            {{-- Action Button --}}
                            @if(auth()->id() == $user->id)
                                <a href="{{ route('profile.edit') }}"
                                   class="px-5 py-2 text-sm border border-gray-600 bg-gray-700/50 hover:bg-gray-700 rounded-lg font-semibold text-white transition-colors">
                                    Edit Profil
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                 
                 {{-- Bio & Stats --}}
                 <div class="mt-6 text-center sm:text-left">
                    @if ($user->bio)
                        <p class="text-gray-300 max-w-xl italic">"{{ $user->bio }}"</p>
                    @else
                        <p class="text-gray-500 italic">You haven't written a bio yet.</p>
                    @endif
                    
                    <div class="flex justify-center sm:justify-start items-center gap-6 mt-4 text-gray-300 pt-4 border-t border-gray-700/50">
                        <div class="text-center">
                            <span class="text-xl font-bold text-cyan-400">{{ $threats->count() }}</span>
                            <span class="text-sm text-gray-400 block">Posts</span>
                        </div>
                        <div class="text-center">
                            <span class="text-xl font-bold text-cyan-400">{{ $total_likes ?? 0 }}</span>
                            <span class="text-sm text-gray-400 block">Likes</span>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    {{-- "My Posts" Section --}}
    <div class="mt-8">
        <h3 class="text-2xl font-bold text-white mb-6">My Posts</h3>
        
        <div class="space-y-6">
            @forelse ($threats as $threat)
                <article class="bg-gray-800/50 border border-gray-700/80 p-5 rounded-xl shadow-lg">
                    <header class="flex items-center gap-4">
                        <img class="w-11 h-11 rounded-full object-cover border-2 border-gray-600"
                             src="https://ui-avatars.com/api/?name={{ urlencode($threat->user->name) }}&background=0D8ABC&color=fff&size=128&font-size=0.5"
                             alt="User Avatar">
                        <div>
                            <p class="font-bold text-base text-cyan-400">{{ $threat->user->name }}</p>
                            <p class="text-xs text-gray-500 font-mono">{{ $threat->created_at->diffForHumans() }}</p>
                        </div>
                    </header>

                    <div class="mt-4 pl-[60px] text-gray-300 text-base leading-relaxed">
                        <p>{{ $threat->content }}</p>
                    </div>

                    <div class="pl-[60px] mt-4 flex items-center gap-6 text-sm text-gray-400">
                        {{-- Like Button --}}
                        <form action="{{ route('threat.like', $threat->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 {{ $threat->isLikedBy(auth()->user()) ? 'text-cyan-400 font-semibold' : 'text-gray-500 hover:text-cyan-400' }} transition-colors">
                                👍 <span>{{ $threat->likes->count() }}</span>
                            </button>
                        </form>
                        
                        {{-- Comment Count --}}
                        <div class="flex items-center gap-2 text-gray-500">
                            💬 <span>{{ $threat->comments->count() }} Komentar</span>
                        </div>
                    </div>

                    {{-- Komentar Form --}}
                    <div class="pl-[60px] mt-4 pt-4 border-t border-gray-700/50">
                        <form action="{{ route('threat.comment', $threat->id) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1f2937&color=fff&size=96" alt="">
                            <input 
                                type="text" 
                                name="comment" 
                                placeholder="Tulis komentar..." 
                                class="flex-1 bg-gray-700/80 border border-transparent text-white rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 transition"
                                required>
                            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-full text-sm font-semibold transition-colors">
                                Kirim
                            </button>
                        </form>
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
                </article>
            @empty
                <div class="text-center py-24 bg-gray-800/40 border border-dashed border-gray-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-5 text-gray-400 text-lg font-medium">You haven't posted anything yet.</p>
                    <p class="text-gray-500 text-sm">Click the '+' button to share your thoughts.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
