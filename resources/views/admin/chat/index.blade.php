@extends('layouts.app')

@section('content')
    <div class="flex h-[80vh] bg-white rounded-xl shadow overflow-hidden">
        <!-- LEFT: USER INBOX -->
        <div class="w-1/4 border-r overflow-y-auto">
            <div class="p-4 font-semibold border-b">Inbox</div>
            <ul id="userList" class="divide-y"></ul>
        </div>

        <!-- RIGHT: CHAT AREA -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div id="chatHeader" class="p-4 border-b font-semibold">
                Select a user
            </div>

            <!-- Messages -->
            <div id="chatBox" class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50"></div>

            <!-- Input -->
            <div class="p-4 border-t flex gap-2">
                <input id="messageInput" class="flex-1 border rounded px-3 py-2" placeholder="Type message..." />
                <button id="sendBtn" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Send
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        let selectedUserId = null;

        // Load inbox users

        let inboxUsers = {};



        function loadInbox(autoUser = null) {

            $.get('/admin/chat/inbox-unread', function(res) {

                $('#userList').html('');
                inboxUsers = {};

                res.users.forEach(item => {

                    inboxUsers[item.from_user_id] = {
                        name: item.name ?? null,
                        phone: item.phone ?? null
                    };

                    let displayText = item.name ?
                        item.name :
                        (item.phone ? item.phone : 'User #' + item.from_user_id);

                    let badge = item.unread_count > 0 ?
                        `<span class="ml-auto bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                        ${item.unread_count}
                   </span>` :
                        '';

                    $('#userList').append(`
                <li class="p-3 hover:bg-gray-100 cursor-pointer flex justify-between items-center"
                    onclick="openChat(${item.from_user_id})">
                    <span class="font-medium">${displayText}</span>
                    ${badge}
                </li>
            `);
                });

                /* ✅ AUTO OPEN AFTER DATA IS READY */
                if (autoUser && inboxUsers[autoUser]) {
                    openChat(autoUser);
                }

            });
        }


        loadInbox();
    </script>

    <script>
        const authUsersMap = @json(\App\Models\User::pluck('name', 'id'));
    </script>
    <script>
        function openChat(userId) {
            selectedUserId = userId;

            let user = inboxUsers[userId] || {};

            let headerText =
                user.name ||
                user.phone ||
                authUsersMap[userId] || // ✅ DB fallback
                'User #' + userId;

            $('#chatHeader').text('Chat with ' + headerText);
            $('#chatBox').html('');

            // MARK AS READ
            $.post('/admin/chat/mark-read/' + userId, {
                _token: '{{ csrf_token() }}'
            }, function() {
                loadInbox();
            });

            $.get('/admin/chat/conversation/' + userId, function(res) {
                res.messages.forEach(msg => {
                    let align = msg.from_role === 'admin' ? 'text-right' : 'text-left';
                    let bg = msg.from_role === 'admin' ? 'bg-blue-200' : 'bg-gray-200';

                    $('#chatBox').append(`
                <div class="${align}">
                    <span class="inline-block px-3 py-2 rounded ${bg}">
                        ${msg.message}
                    </span>
                </div>
            `);
                });

                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
            });
        }
    </script>

    <script>
        $('#sendBtn').click(function() {
            let msg = $('#messageInput').val();
            if (!msg || !selectedUserId) return;

            // UI instantly show
            $('#chatBox').append(`
                <div class="text-right">
                    <span class="inline-block px-3 py-2 rounded bg-blue-200">
                        ${msg}
                    </span>
                </div>
            `);

            $.post('/admin/chat/send', {
                _token: '{{ csrf_token() }}',
                to_user_id: selectedUserId,
                message: msg
            });

            $('#messageInput').val('');
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
        });

        // Allow Enter key to send message
        $('#messageInput').keypress(function(e) {
            if (e.which === 13) { // Enter key
                $('#sendBtn').click();
            }
        });
    </script>

    <!-- FIXED PUSHER LISTENER -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Pusher with your credentials
            const pusher = new Pusher('c785a3a516330c86b8fb', {
                cluster: 'ap2',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

            // Get current admin ID
            const adminId = {{ auth()->id() }};

            console.log('Admin ID for private channel:', adminId);

            // Subscribe to admin's private channel
            const adminChannel = pusher.subscribe('private-user.' + adminId);

            // Listen for user messages
            adminChannel.bind('user-chat-message', function(data) {
                console.log('User message received on admin side:', data);

                // Check if this message is from the currently selected user
                if (selectedUserId && data.fromUserId === selectedUserId) {
                    // Add message to chat box
                    $('#chatBox').append(`
                        <div class="text-left">
                            <span class="inline-block px-3 py-2 rounded bg-gray-200">
                                ${data.message}
                            </span>
                        </div>
                    `);

                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                }

                // Refresh inbox to show new message indicator
                loadInbox();
            });

            // Also subscribe to a public channel for debug
            const publicChannel = pusher.subscribe('bsmr-chat');
            publicChannel.bind('user-chat-message', function(data) {
                console.log('Public channel debug - User message:', data);
            });

            console.log('Pusher initialized and listening for messages...');

            // Connection events for debugging
            pusher.connection.bind('state_change', function(states) {
                console.log('Connection state changed:', states.current);
            });

            pusher.connection.bind('error', function(error) {
                console.error('Pusher connection error:', error);
            });
        });
    </script>

    <script>
        function getQueryUser() {
            const params = new URLSearchParams(window.location.search);
            return params.get('user');
        }

        $(document).ready(function() {

            loadInbox();

            const autoUser = getQueryUser();

            if (autoUser) {

                // Wait a little so inbox loads first
                setTimeout(() => {
                    openChat(autoUser);
                }, 500);

            }
        });
    </script>
@endsection
