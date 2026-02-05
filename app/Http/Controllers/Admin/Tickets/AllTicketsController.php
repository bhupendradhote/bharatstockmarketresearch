<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\MasterNotification;
use App\Models\MasterNotificationRead;
use Illuminate\Support\Facades\Log;

class AllTicketsController extends Controller
{
 public function index()
{
    $adminId = auth()->id();

    Log::info('🎫 Admin opened tickets page', ['admin_id' => $adminId]);

    /* ===============================
       ✅ MARK ALL TICKET NOTIFICATIONS READ
    =============================== */

    $ticketNotificationIds = MasterNotification::where('type', 'ticket')
        ->where('user_id', $adminId)
        ->pluck('id');

    foreach ($ticketNotificationIds as $nid) {
        MasterNotificationRead::updateOrCreate(
            [
                'master_notification_id' => $nid,
                'user_id' => $adminId
            ],
            [
                'read_at' => now()
            ]
        );
    }

    Log::info('✅ Ticket notifications marked as read', [
        'count' => $ticketNotificationIds->count()
    ]);

    /* ===============================
       🎫 LOAD TICKETS
    =============================== */

    $tickets = Ticket::latest()->get();

    return view('admin.tickets.all', compact('tickets'));
}

public function open($id)
{
    $ticket = Ticket::findOrFail($id);

    // Sirf tabhi update karein agar status 'In Progress' hai
    // Agar status 'Open' ya 'Resolved' hai, toh skip karein
    if ($ticket->status === 'In Progress') {
        $ticket->status = 'Open';
        $ticket->save();
        
        Log::info('Ticket status updated to Open', ['ticket_id' => $id]);
        
        return response()->json([
            'success' => true,
            'updated' => true,
            'ticket' => $ticket
        ]);
    }

    // Agar update nahi hua toh purana data hi bhej dein success ke saath
    return response()->json([
        'success' => true,
        'updated' => false,
        'ticket' => $ticket
    ]);
}

public function resolve(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $ticket->status = 'Resolved';
    $ticket->admin_note = $request->admin_note;
    $ticket->save();

    return response()->json([
        'success' => true,
        'ticket' => $ticket
    ]);
}
}