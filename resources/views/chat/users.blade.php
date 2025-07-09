@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-white tracking-tight">Conversations</h2>
        <p class="text-gray-400 mt-1">Select a user to start or continue a chat.</p>
    </header>

    @if ($users->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-24 bg-gray-800/40 border border-dashed border-gray-700 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="mt-5 text-gray-400 text-lg font-medium">No other users found.</p>
            <p class="text-gray-500 text-sm">When other people join, you will see them here.</p>
        </div>
    @else
        {{-- User List --}}
        <div class="bg-gray-800/50 border border-gray-700/80 rounded-xl shadow-lg">
            <ul class="divide-y divide-gray-700/50">
                @foreach ($users as $user)
                    <li 
                        class="group transition-colors duration-200 hover:bg-gray-700/50"
                        onclick="window.location='{{ route('chat.show', $user->id) }}'"
                        style="cursor: pointer;"
                    >
                        <div class="flex items-center justify-between p-4">
                            {{-- Left Side: Avatar and Info --}}
                            <div class="flex items-center gap-4">
                                {{-- The outer 'a' tag for the profile link is maintained --}}
                                <a 
                                    href="{{ route('profile.public', $user->id) }}" 
                                    onclick="event.stopPropagation();" 
                                    class="relative flex-shrink-0"
                                    title="View Profile"
                                >
                                    <img 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-600 group-hover:border-cyan-500 transition-colors"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128&font-size=0.5" 
                                        alt="{{ $user->name }}'s avatar">
                                </a>
                                <div>
                                    <h3 class="font-bold text-base text-white group-hover:text-cyan-400 transition-colors">
                                        {{ $user->name }}
                                    </h3>
                                    <p class="text-sm text-gray-400 truncate max-w-xs sm:max-w-sm">
                                        @if ($user->last_message)
                                            {{ $user->last_message->message }}
                                        @else
                                            <em class="text-gray-500">No messages yet. Click to start.</em>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Right Side: Chevron Icon --}}
                            <div class="text-gray-500 group-hover:text-cyan-400 group-hover:translate-x-1 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection