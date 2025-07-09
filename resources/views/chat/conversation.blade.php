@extends('layouts.app')

@section('content')
<div 
    x-data="chatComponent()" 
    x-init="init()"
    {{-- FIXED: Reduced height to prevent overflow and ensure all page elements are visible --}}
    class="flex flex-col h-[75vh] bg-gray-800/50 border border-gray-700/80 rounded-xl shadow-2xl"
>
    {{-- Chat Header --}}
    <header class="flex items-center gap-4 p-4 border-b border-gray-700/80 flex-shrink-0">
        <a href="{{ route('chat.users') }}" class="text-gray-400 hover:text-white transition-colors" title="Back to conversations">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <a href="{{ route('profile.public', $user->id) }}" class="flex items-center gap-4">
             <img class="object-cover w-11 h-11 rounded-full border-2 border-gray-600" 
                 src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128&font-size=0.5" 
                 alt="{{ $user->name }}">
            <h2 class="text-lg font-bold text-white hover:text-cyan-400 transition-colors">{{ $user->name }}</h2>
        </a>
    </header>

    {{-- Messages Container --}}
    <div x-ref="messagesContainer" class="flex-1 p-4 sm:p-6 space-y-4 overflow-y-auto custom-scrollbar">
        @foreach ($messages as $msg)
            <div class="flex items-end gap-2 {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $msg->id }}">
                @if($msg->sender_id != auth()->id())
                    <img class="w-8 h-8 rounded-full border-2 border-gray-600 flex-shrink-0" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1f2937&color=fff&size=96" 
                         alt="{{ $user->name }}">
                @endif
                <div class="max-w-md">
                    <div class="px-4 py-2.5 rounded-2xl {{ $msg->sender_id == auth()->id() ? 'bg-cyan-600 text-white rounded-br-none' : 'bg-gray-700 text-gray-200 rounded-bl-none' }}">
                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                    </div>
                    <div class="px-2 mt-1.5 text-xs text-gray-500 {{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Message Input Form --}}
    <footer class="p-4 border-t border-gray-700/80 flex-shrink-0">
        <form @submit.prevent="sendMessage" class="flex items-center gap-3">
            @csrf
            <input 
                type="text" 
                x-model="newMessage"
                class="flex-1 bg-gray-700/80 text-white rounded-full py-3 px-5 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all duration-200" 
                placeholder="Type a message..." 
                required
            >
            <button 
                type="submit"
                class="bg-cyan-600 hover:bg-cyan-500 text-white rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center transition-all duration-200 transform hover:scale-110"
                title="Send Message"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.428A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
            </button>
        </form>
    </footer>
</div>

{{-- The CSS and JavaScript remain exactly the same --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #1e293b; /* slate-800 */
        border-radius: 20px;
        border: 2px solid #334155; /* slate-700 */
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #475569; /* slate-600 */
    }
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #1e293b #334155;
    }
</style>

<script>
function chatComponent() {
    return {
        newMessage: '',
        authUserId: {{ auth()->id() }},
        lastMessageId: {{ $messages->last()->id ?? 0 }},
        isLoading: false,

        init() {
            this.$nextTick(() => this.scrollToBottom('instant'));
            
            setInterval(() => {
                this.fetchNewMessages();
            }, 3000);
        },
        
        scrollToBottom(behavior = 'smooth') {
            this.$refs.messagesContainer.scrollTo({
                top: this.$refs.messagesContainer.scrollHeight,
                behavior: behavior
            });
        },

        fetchNewMessages() {
            if (this.isLoading) return;
            this.isLoading = true;

            fetch(`{{ route('chat.fetch', $user->id) }}?last_message_id=${this.lastMessageId}`)
                .then(res => res.json())
                .then(newMessages => {
                    if (newMessages.length > 0) {
                        const isScrolledToBottom = this.$refs.messagesContainer.scrollHeight - this.$refs.messagesContainer.scrollTop <= this.$refs.messagesContainer.clientHeight + 50;
                        
                        newMessages.forEach(msg => {
                            this.appendMessageToDOM(msg);
                            this.lastMessageId = msg.id;
                        });
                        
                        if (isScrolledToBottom) {
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    }
                })
                .catch(error => console.error('Failed to fetch new messages:', error))
                .finally(() => this.isLoading = false);
        },

        sendMessage() {
            if (this.newMessage.trim() === '') return;
            const tempMessage = this.newMessage;
            this.newMessage = '';

            fetch(`{{ route('chat.send', $user->id) }}`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: tempMessage }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && !document.querySelector(`[data-message-id='${data.data.id}']`)) {
                    this.appendMessageToDOM(data.data);
                    this.lastMessageId = data.data.id;
                    this.$nextTick(() => this.scrollToBottom());
                } else if (!data.success) {
                    this.newMessage = tempMessage;
                    alert('Failed to send message: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                this.newMessage = tempMessage;
            });
        },

        appendMessageToDOM(msg) {
            const container = this.$refs.messagesContainer;
            const time = new Date(msg.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
            const isSender = msg.sender_id == this.authUserId;
            
            const messageWrapper = document.createElement('div');
            messageWrapper.dataset.messageId = msg.id;
            messageWrapper.className = `flex items-end gap-2 ${isSender ? 'justify-end' : 'justify-start'}`;

            let avatarHtml = '';
            if (!isSender) {
                avatarHtml = `<img class="w-8 h-8 rounded-full border-2 border-gray-600 flex-shrink-0" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1f2937&color=fff&size=96" alt="{{ $user->name }}">`;
            }

            messageWrapper.innerHTML = `
                ${avatarHtml}
                <div class="max-w-md">
                    <div class="px-4 py-2.5 rounded-2xl ${isSender ? 'bg-cyan-600 text-white rounded-br-none' : 'bg-gray-700 text-gray-200 rounded-bl-none'}">
                        <p class="text-sm leading-relaxed">${msg.message.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</p>
                    </div>
                    <div class="px-2 mt-1.5 text-xs text-gray-500 ${isSender ? 'text-right' : 'text-left'}">
                        ${time}
                    </div>
                </div>
            `;
            container.appendChild(messageWrapper);
        }
    }
}
</script>
@endsection