<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\User;
use App\Models\Tip;
use App\Models\UserSubscription;
use App\Models\MessageCampaignLog;
use App\Models\Invoice; 
use App\Models\OfferBanner;
use App\Models\Ticket;
use App\Models\ServicePlan;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Dashboard Stats
        $stats = [
            'total_users'     => User::role('customer')->count(),
            'active_tips'     => Tip::where('status', 'Active')->where('trade_status', 'Open')->count(),
            'active_subs'     => UserSubscription::where('status', 'active')->where('payment_status', '!=', 'demo')->count(), // Paid Active
            'active_demos'    => UserSubscription::where('status', 'active')->where('payment_status', 'demo')->count(),      // ✅ Added Demo Stat
            'total_revenue'   => Invoice::sum('amount'), 
            'campaign_views'  => MessageCampaignLog::whereDate('created_at', today())->count(),
            'active_banners'  => OfferBanner::where('is_active', 1)->count(),
            'pending_tickets' => Ticket::where('status', 'Open')->count(),
        ];

        // 2. Data Tables (Independent Pagination)
        
        $users = User::with('media')
            ->role('customer')
            ->latest()
            ->paginate(5, ['*'], 'users_page');

        $tips = Tip::with('category')
            ->latest()
            ->paginate(5, ['*'], 'tips_page');

        $banners = OfferBanner::orderBy('position', 'asc')
            ->latest()
            ->paginate(5, ['*'], 'banners_page');

        $tickets = Ticket::latest()
            ->paginate(5, ['*'], 'tickets_page');

        $servicePlans = ServicePlan::with('durations')
            ->latest()
            ->paginate(5, ['*'], 'plans_page');

        // Paid Subscriptions List
        $subscriptions = UserSubscription::with(['user']) 
            ->where('payment_status', '!=', 'demo') // Exclude demos from main list
            ->latest()
            ->paginate(5, ['*'], 'subs_page');

        // ✅ Added Demo Subscriptions List
        $demoSubscriptions = UserSubscription::with(['user'])
            ->where('payment_status', 'demo')
            ->latest()
            ->paginate(5, ['*'], 'demos_page');

        $campaignLogs = MessageCampaignLog::with('user')
            ->latest()
            ->paginate(5, ['*'], 'logs_page');

        return view('dashboard', compact(
            'stats',
            'users',
            'tips',
            'banners',
            'tickets',
            'servicePlans',
            'subscriptions',
            'demoSubscriptions', // ✅ Passed to view
            'campaignLogs'
        ));
    }
}