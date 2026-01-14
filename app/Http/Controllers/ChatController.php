<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatMessageSent;

class ChatController extends Controller
{
    // GET messages from session
    public function getMessages()
    {
        return response()->json(
            session()->get('chat_messages', [])
        );
    }

    // SEND message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Always ensure session exists
        $messages = session()->get('chat_messages', []);

        $messages[] = $request->message;

        session()->put('chat_messages', $messages);

        // 🔥 Broadcast
        broadcast(new ChatMessageSent($request->message));

        return response()->json(['status' => 'sent']);
    }
}
