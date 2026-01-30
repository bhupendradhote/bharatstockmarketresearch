<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserAnnouncementController extends Controller
{
    public function index()
    {
        // 1. Fetch active announcements, sorted by newest first
        $announcements = Announcement::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($item) {
                // 2. Transform data for the frontend
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type, // 'Features', 'Service Update', 'Others'
                    'content' => $item->content,
                    'detail' => $item->detail,
                    // Format for list: "Today", "2 days ago"
                    'date_human' => $item->published_at ? Carbon::parse($item->published_at)->diffForHumans() : 'Just now',
                    // Format for details: "30 Nov 2025"
                    'date_formatted' => $item->published_at ? Carbon::parse($item->published_at)->format('d M Y') : date('d M Y'),
                    // Flag for "New" badge (e.g., posted within last 3 days)
                    'is_new' => $item->created_at > now()->subDays(3),
                ];
            });

        // 3. Return the view with data
        return view('UserDashboard.announcement.announcement', [
            'announcements' => $announcements
        ]);
    }
}