<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscription;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;

class PaymentInvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /**
         * 🔹 Load all subscriptions (old + new)
         * 🔹 Active subscription first
         * 🔹 With invoices + plan
         */
        $subscriptions = UserSubscription::with([
                'plan',
                'invoices'
            ])
            ->where('user_id', $user->id)
            ->orderByRaw("status = 'active' DESC") // active on top
            ->orderByDesc('start_date')
            ->get();

        return view('userdashboard.settings.payments_invoicesList', compact('subscriptions'));
    }

      public function show()
    {
        $user = Auth::user();

        /**
         * 🔹 Active Subscription (only one)
         */
        $activeSubscription = UserSubscription::with(['plan', 'duration'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('payment_status', 'paid')
            ->latest('start_date')
            ->first();

        return view('UserDashboard.settings.payment&invoice', [
            'activeSubscription' => $activeSubscription,
        ]);
    }

     public function download(Invoice $invoice)
    {
        // 🔒 Security: invoice belongs to logged-in user
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load([
            'user',
            'subscription.plan',
            'subscription.duration'
        ]);

        $pdf = Pdf::loadView('UserDashboard.settings.invoice-pdf', [
            'invoice' => $invoice,
        ])->setPaper('A4');

        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
