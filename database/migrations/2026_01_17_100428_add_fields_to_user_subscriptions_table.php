<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {

            /* ===============================
             * 💰 PAYMENT DETAILS
             * =============================== */
            $table->decimal('amount', 10, 2)
                  ->after('service_plan_duration_id')
                  ->nullable()
                  ->comment('Final amount paid');

            $table->string('currency', 10)
                  ->default('INR')
                  ->after('amount');

            $table->string('payment_gateway', 30)
                  ->default('razorpay')
                  ->after('currency');

            /* ===============================
             * 🔐 RAZORPAY IDS
             * =============================== */
            $table->string('razorpay_order_id')
                  ->nullable()
                  ->after('payment_reference');

            $table->string('razorpay_payment_id')
                  ->nullable()
                  ->after('razorpay_order_id');

            $table->string('razorpay_signature')
                  ->nullable()
                  ->after('razorpay_payment_id');

            /* ===============================
             * 📌 PAYMENT STATUS
             * =============================== */
            $table->enum('payment_status', [
                    'created',
                    'paid',
                    'failed',
                    'refunded'
                ])
                ->default('created')
                ->after('razorpay_signature');

            /* ===============================
             * 🧾 RAW RESPONSE (JSON)
             * =============================== */
            $table->json('payment_payload')
                  ->nullable()
                  ->after('payment_status');

            /* ===============================
             * 🔍 INDEXES
             * =============================== */
            $table->index('razorpay_order_id');
            $table->index('razorpay_payment_id');
            $table->index(['user_id', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {

            $table->dropIndex(['razorpay_order_id']);
            $table->dropIndex(['razorpay_payment_id']);
            $table->dropIndex(['user_id', 'payment_status']);

            $table->dropColumn([
                'amount',
                'currency',
                'payment_gateway',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'payment_status',
                'payment_payload',
            ]);
        });
    }
};
