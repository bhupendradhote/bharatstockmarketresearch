@extends('layouts.user')

@section('content')
    <div class="max-w-xl mx-auto mt-24 bg-white rounded-lg shadow flex flex-col h-[500px]">

        <!-- HEADER -->
        <div class="p-4 border-b font-semibold text-center">
            Support Chat
        </div>

        <!-- CHAT MESSAGES -->
        <div id="chatBox" class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50">
        </div>

        <!-- INPUT -->
        <div class="p-4 border-t flex gap-2">
            <input type="text" id="messageInput" placeholder="Type your message..."
                class="flex-1 border rounded px-3 py-2 focus:outline-none" />
            <button id="sendBtn" class="bg-blue-600 text-white px-4 py-2 rounded">
                Send
            </button>
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        /* ================================
               LOAD OLD CHAT HISTORY
            ================================ */
        function loadMessages() {
            $.get('/user/chat/history', function(res) {
                $('#chatBox').html('');

                res.messages.forEach(msg => {
                    let isUser = msg.from_role === 'user';

                    $('#chatBox').append(`
                <div class="${isUser ? 'text-right' : 'text-left'}">
                    <span class="inline-block px-3 py-2 rounded
                        ${isUser ? 'bg-blue-200' : 'bg-gray-200'}">
                        ${msg.message}
                    </span>
                </div>
            `);
                });

                scrollBottom();
            });
        }

        loadMessages();

        /* ================================
           SEND MESSAGE (USER → ADMIN)
        ================================ */
        $('#sendBtn').on('click', function() {
            let msg = $('#messageInput').val().trim();
            if (!msg) return;

            // ✅ User side instant show
            $('#chatBox').append(`
        <div class="text-right">
            <span class="inline-block px-3 py-2 rounded bg-blue-200">
                ${msg}
            </span>
        </div>
    `);

            scrollBottom();

            // Send to server
            $.post('/user/chat/send', {
                _token: '{{ csrf_token() }}',
                message: msg
            });

            $('#messageInput').val('');
        });

        /* ================================
           PUSHER: ADMIN → USER MESSAGE
        ================================ */
        Pusher.logToConsole = false;

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
        var channel = pusher.subscribe('private-user.' + userId);

        // 🔥 Admin message receive
        channel.bind('admin-chat-message', function(data) {
            $('#chatBox').append(`
        <div class="text-left">
            <span class="inline-block px-3 py-2 rounded bg-gray-200">
                ${data.message}
            </span>
        </div>
    `);

            scrollBottom();
        });

        /* ================================
           AUTO SCROLL
        ================================ */
        function scrollBottom() {
            let box = $('#chatBox');
            box.scrollTop(box[0].scrollHeight);
        }
    </script>

    <script>
        window.addEventListener('chat-user-message', function(event) {
            const data = event.detail;

            if (selectedUserId === data.fromUserId) {
                $('#chatBox').append(`
            <div class="text-left">
                <span class="inline-block px-3 py-2 rounded bg-gray-200">
                    ${data.message}
                </span>
            </div>
        `);

                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
            }
        });
    </script>
@endsection
