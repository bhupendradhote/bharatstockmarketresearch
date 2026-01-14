<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\AdminChatMessageSent; 
use Illuminate\Support\Facades\DB;

class AdminChatController extends Controller
{
    /**
     * Admin → User message send
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'message'    => 'required|string|max:2000',
        ]);

        $admin = Auth::user();

        // Message save
        $chat = ChatMessage::create([
            'from_user_id' => $admin->id,
            'to_user_id'   => $request->to_user_id,
            'message'      => $request->message,
            'from_role'    => 'admin',
        ]);

        // BROADCAST THE MESSAGE - ADD THIS LINE
        broadcast(new AdminChatMessageSent($admin->id, $request->to_user_id, $request->message));

        return response()->json([
            'success' => true,
            'data' => $chat,
        ]);
    }

    /**
     * Admin ↔ User conversation fetch
     */
    public function getConversation($userId)
    {
        $adminId = auth()->id();

        $messages = \App\Models\ChatMessage::where(function ($q) use ($adminId, $userId) {
                $q->where('from_user_id', $adminId)
                  ->where('to_user_id', $userId);
            })
            ->orWhere(function ($q) use ($adminId, $userId) {
                $q->where('from_user_id', $userId)
                  ->where('to_user_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Admin inbox – unique users list
     */
    public function inbox()
    {
        $adminId = auth()->id();

        $users = \App\Models\ChatMessage::where('to_user_id', $adminId)
            ->orWhere('from_user_id', $adminId)
            ->with('fromUser')
            ->select('from_user_id')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

//     public function inboxWithUnread()
// {
//     $adminId = auth()->id();

//     $users = ChatMessage::select(
//             'from_user_id',
//             DB::raw('SUM(CASE WHEN is_read = 0 AND to_user_id = '.$adminId.' THEN 1 ELSE 0 END) as unread_count')
//         )
//         ->where(function ($q) use ($adminId) {
//             $q->where('to_user_id', $adminId)
//               ->orWhere('from_user_id', $adminId);
//         })
//         ->groupBy('from_user_id')
//         ->get();

//     return response()->json([
//         'success' => true,
//         'users' => $users
//     ]);
// }
public function inboxWithUnread()
{
    $adminId = auth()->id();

    $users = ChatMessage::join('users', 'users.id', '=', 'chat_messages.from_user_id')
        ->where(function ($q) use ($adminId) {
            $q->where('chat_messages.to_user_id', $adminId)
              ->orWhere('chat_messages.from_user_id', $adminId);
        })
        ->select(
            'chat_messages.from_user_id',
            'users.name',
            'users.phone',
            DB::raw('SUM(CASE WHEN chat_messages.is_read = 0 AND chat_messages.to_user_id = '.$adminId.' THEN 1 ELSE 0 END) as unread_count')
        )
        ->groupBy('chat_messages.from_user_id', 'users.name', 'users.phone')
        ->get();

    return response()->json([
        'success' => true,
        'users' => $users
    ]);
}
public function markAsRead($userId)
{
    $adminId = auth()->id();

    ChatMessage::where('from_user_id', $userId)
        ->where('to_user_id', $adminId)
        ->where('is_read', 0)
        ->update(['is_read' => 1]);

    return response()->json(['success' => true]);
}


}