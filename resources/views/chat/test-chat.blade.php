<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BSMR Chat Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f9ff;
        }

        .chat-wrapper {
            max-width: 600px;
            margin: 60px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .chat-box {
            min-height: 200px;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow-y: auto;
        }

        .message {
            background: #e0f2fe;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .input-row {
            display: flex;
            gap: 10px;
        }

        input {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }

        button {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            background: #38bdf8;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #0ea5e9;
        }
    </style>
</head>

<body>

    <div class="chat-wrapper">
        <h3>🧪 BSMR Pusher Chat Test</h3>

        <div id="chatBox" class="chat-box"></div>

        <div class="input-row">
            <input type="text" id="messageInput" placeholder="Type message...">
            <button id="sendBtn">Send</button>
        </div>
    </div>

    {{-- <script>
        // Enable debug
        Pusher.logToConsole = true;

        // Init Pusher
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        // Subscribe channel
        var channel = pusher.subscribe('bsmr-chat');

        // Listen event
        channel.bind('App\\Events\\ChatMessageSent', function(data) {
            $('#chatBox').append(
                '<div class="message">' + data.message + '</div>'
            );
        });

        // Send message
        $('#sendBtn').click(function() {
            let message = $('#messageInput').val();

            if (message.trim() === '') return;

            $.post('{{ url('/send-message') }}', {
                _token: '{{ csrf_token() }}',
                message: message
            });

            $('#messageInput').val('');
        });
    </script> --}}

    {{-- <script>
        // 1️⃣ LOAD OLD SESSION MESSAGES FIRST
        // $(document).ready(function() {
        //     $.get('/get-messages', function(messages) {
        //         messages.forEach(function(msg) {
        //             $('#chatBox').append(
        //                 '<div class="message">' + msg + '</div>'
        //             );
        //         });
        //     });
        // });

        // 2️⃣ PUSHER INIT
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('bsmr-chat');

        // 3️⃣ REAL-TIME MESSAGE RECEIVE
        channel.bind('App\\Events\\ChatMessageSent', function(data) {
            $('#chatBox').append(
                '<div class="message">' + data.message + '</div>'
            );
        });

        // 4️⃣ SEND MESSAGE
        $('#sendBtn').click(function() {
            let message = $('#messageInput').val();

            if (message.trim() === '') return;

            $.post('{{ url('/send-message') }}', {
                _token: '{{ csrf_token() }}',
                message: message
            });

            $('#messageInput').val('');
        });
    </script> --}}

    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('bsmr-chat');

        // ✅ REAL TIME MESSAGE
        channel.bind('chat-message', function(data) {
            console.log('RECEIVED:', data);
            $('#chatBox').append(
                '<div class="message">' + data.message + '</div>'
            );
        });


        // ✅ SEND MESSAGE
        $('#sendBtn').click(function() {
            let message = $('#messageInput').val();
            if (!message.trim()) return;

            // 👇 sender ke liye instantly show
            $('#chatBox').append(
                '<div class="message">' + message + '</div>'
            );

            $.post('{{ url('/send-message') }}', {
                _token: '{{ csrf_token() }}',
                message: message
            });

            $('#messageInput').val('');
        });
    </script>


</body>

</html>
