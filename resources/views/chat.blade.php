@extends('layouts.user')

@section('content')
    <div class="flex flex-col h-[calc(100vh-64px)] mt-20 bg-gray-100 overflow-hidden">

        <div class="flex flex-1 overflow-hidden">

            <div class="flex flex-col flex-1 bg-white shadow-2xl relative">

                <div
                    class="px-6 py-4 border-b flex justify-between items-center bg-white/80 backdrop-blur-md sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-400 flex items-center justify-center shadow-lg text-blue font-bold text-xl">
                                S
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-lg leading-tight">Support Concierge</h2>
                            <p class="text-xs font-medium text-gray-500 flex items-center gap-1.5 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-ping"></span>
                                Live Support Active
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="/help-center"
                            class="hidden md:flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-blue-400 hover:text-blue-600 text-gray-600 rounded-xl transition-all font-semibold text-sm shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Raise Ticket
                        </a>
                    </div>
                </div>

                <div id="chatBox" class="flex-1 overflow-y-auto px-6 py-8 space-y-6 bg-[#fcfdfe] scroll-smooth">
                </div>

                <div class="p-6 bg-white border-t border-gray-100">
                    <div
                        class="max-w-4xl mx-auto relative flex items-center gap-3 bg-gray-50 p-2 rounded-2xl border border-gray-200 focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition-all duration-300 shadow-inner">
                        <input type="text" id="messageInput" autocomplete="off" placeholder="Type your message here..."
                            class="flex-1 bg-transparent border-none focus:ring-0 text-gray-700 px-4 py-3 text-base outline-none placeholder:text-gray-400" />

                        <button id="sendBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white p-3.5 rounded-xl transition-all active:scale-95 shadow-lg shadow-blue-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-center text-[10px] text-gray-400 mt-3 italic">Our team usually responds within a few
                        minutes.</p>
                </div>
            </div>

            <div class="hidden lg:flex flex-col w-80 bg-gray-50 border-l border-gray-200 p-8 space-y-8">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Quick Links</h3>
                    <nav class="space-y-3">
                        <a href="/" class="block text-sm text-gray-600 hover:text-blue-600 transition-colors">How it
                            works?</a>
                        <a href="/legal" class="block text-sm text-gray-600 hover:text-blue-600 transition-colors">Privacy
                            Policy</a>
                        <a href="/help-center" class="block text-sm text-blue-600 font-bold">Need technical help?</a>
                    </nav>
                </div>

                <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-sm font-medium opacity-90 mb-2">Priority Support</p>
                    <h4 class="text-lg font-bold leading-snug">Got a complex issue?</h4>
                    <p class="text-xs mt-3 opacity-80 leading-relaxed">Raising a ticket allows our senior technicians to
                        review your logs immediately.</p>
                    <a href="/help-center"
                        class="mt-4 block text-center py-2 bg-white text-blue-600 rounded-lg text-xs font-bold uppercase tracking-wider">Go
                        to Help Center</a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        function appendMessage(msg, isUser) {
            const bubbleStyle = isUser ?
                'bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-blue-100' :
                'bg-white text-gray-800 border border-gray-100 rounded-2xl rounded-tl-none shadow-sm';

            const wrapperStyle = isUser ? 'justify-end' : 'justify-start';

            const timestamp = new Date().toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            $('#chatBox').append(`
            <div class="flex ${wrapperStyle} animate-slide-in">
                <div class="flex flex-col max-w-[75%] md:max-w-[60%]">
                    <div class="px-5 py-3 rounded-2xl shadow-md ${bubbleStyle}">
                        <p class="text-sm md:text-base leading-relaxed">${msg}</p>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 ${isUser ? 'text-right' : 'text-left px-2'}">${timestamp}</span>
                </div>
            </div>
        `);
            scrollBottom();
        }

        // ... Load Messages, Send Logic, and Pusher Logic (Identical to previous version) ...
        // Note: Ensuring scrollBottom works perfectly for full page
        function scrollBottom() {
            const chatBox = document.getElementById('chatBox');
            chatBox.scrollTo({
                top: chatBox.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Re-linking your existing logic
        function loadMessages() {
            $.get('/user/chat/history', function(res) {
                $('#chatBox').html('');
                res.messages.forEach(msg => {
                    appendMessage(msg.message, msg.from_role === 'user');
                });
            });
        }

        loadMessages();

        $('#sendBtn').on('click', function() {
            let msg = $('#messageInput').val().trim();
            if (!msg) return;
            appendMessage(msg, true);
            $('#messageInput').val('');
            $.post('/user/chat/send', {
                _token: '{{ csrf_token() }}',
                message: msg
            });
        });

        $('#messageInput').on('keypress', function(e) {
            if (e.which == 13) $('#sendBtn').click();
        });


        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        var userId = {{ auth()->id() }};

        // ✅ PRIVATE USER CHANNEL (MATCHING YOUR EVENT)
        var channel = pusher.subscribe('private-user.' + userId);

        channel.bind('master.notification', function(data) {

            console.log('Realtime received:', data);

            // Only chat notifications
            if (data.type !== 'chat') return;

            appendMessage(data.message, false);
        });
    </script>

    <style>
        /* Modern Slide-in Animation */
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-slide-in {
            animation: slide-in 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Custom Scrollbar for Chat */
        #chatBox::-webkit-scrollbar {
            width: 6px;
        }

        #chatBox::-webkit-scrollbar-track {
            background: transparent;
        }

        #chatBox::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        #chatBox::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>
@endsection
