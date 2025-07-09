@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-white tracking-tight">Edit Profile</h2>
        <p class="text-gray-400 mt-1">Update your name and bio information below.</p>
    </header>

    {{-- Form Card --}}
    <div class="bg-gray-800/50 border border-gray-700/80 rounded-xl shadow-lg p-6 sm:p-8">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 mb-6 bg-green-500/10 border border-green-500/30 text-green-300 text-sm rounded-lg" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-300">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    class="w-full bg-gray-700/80 border border-gray-600/80 text-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all"
                >
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block mb-2 text-sm font-medium text-gray-300">Bio</label>
                <textarea 
                    id="bio" 
                    name="bio" 
                    rows="4" 
                    placeholder="Tell us a little about yourself..."
                    class="w-full bg-gray-700/80 border border-gray-600/80 text-gray-200 rounded-lg p-3 resize-none focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all"
                >{{ old('bio', $user->bio) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="pt-4 flex items-center justify-end gap-4">
                 <a href="{{ route('profile') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-lg transition-colors focus:outline-none focus:ring-4 focus:ring-cyan-500/50"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection