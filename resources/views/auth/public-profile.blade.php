@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center gap-2 text-sm text-cyan-400 hover:text-cyan-300 transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

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

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-3">
                                @if(auth()->id() == $user->id)
                                    <a href="#" {{-- Replace with your edit route --}}
                                       class="px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold transition-colors">
                                        Edit Profile
                                    </a>
                                @else
                                    <a href="{{ route('chat.show', $user->id) }}" 
                                       class="px-5 py-2 text-sm bg-cyan-600 hover:bg-cyan-700 rounded-lg font-semibold text-white transition-colors flex items-center gap-2"
                                       title="Start Chat">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                            <path d="M15 7v2a2 2 0 012 2v5a2 2 0 01-2 2h-1v-2a4 4 0 00-4-4H9V7a4 4 0 014-4h2z" />
                                        </svg>
                                        Message
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                 {{-- Bio & Stats --}}
                 <div class="mt-6 text-center sm:text-left">
                    @if ($user->bio)
                        <p class="text-gray-300 max-w-xl italic">"{{ $user->bio }}"</p>
                    @else
                        <p class="text-gray-500 italic">No bio available.</p>
                    @endif
                    
                    <div class="flex justify-center sm:justify-start items-center gap-6 mt-4 text-gray-300 pt-4 border-t border-gray-700/50">
                        <div class="text-center">
                            <span class="text-xl font-bold text-cyan-400">{{ $threats->count() }}</span>
                            <span class="text-sm text-gray-400 block">Posts</span>
                        </div>
                        <div class="text-center">
                            <span class="text-xl font-bold text-cyan-400">{{ $user->total_likes ?? 0 }}</span>
                            <span class="text-sm text-gray-400 block">Likes</span>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    {{-- Posts Section --}}
    <div class="mt-8">
        <h3 class="text-2xl font-bold text-white mb-6">Posts</h3>
        
        <div class="space-y-6">
            @forelse ($threats as $threat)
                {{-- This reuses the exact same post component style from the dashboard for consistency --}}
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
                        <form action="{{ route('threat.like', $threat->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 {{ $threat->isLikedBy(auth()->user()) ? 'text-cyan-400 font-semibold' : 'text-gray-500 hover:text-cyan-400' }} transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.563 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a2 2 0 00-.8 1.4z" /></svg>
                                <span>{{ $threat->likes->count() }}</span>
                            </button>
                        </form>
                         <div class="flex items-center gap-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" /></svg>
                            <span>{{ $threat->comments->count() }} Comments</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-24 bg-gray-800/40 border border-dashed border-gray-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-5 text-gray-400 text-lg font-medium">No posts to display.</p>
                    <p class="text-gray-500 text-sm">This user hasn't posted anything yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection