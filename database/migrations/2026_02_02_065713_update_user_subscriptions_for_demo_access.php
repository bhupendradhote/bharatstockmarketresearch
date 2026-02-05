<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {

            // Allow NULL for demo (no specific plan)
            $table->foreignId('service_plan_id')
                  ->nullable()
                  ->change();

            $table->foreignId('service_plan_duration_id')
                  ->nullable()
                  ->change();

            // Add demo in payment_status enum
            $table->enum('payment_status', [
                    'created',
                    'paid',
                    'failed',
                    'refunded',
                    'demo'
                ])
                ->default('created')
                ->change();

        });
    }

    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {

            // Revert nullable
            $table->foreignId('service_plan_id')
                  ->nullable(false)
                  ->change();

            $table->foreignId('service_plan_duration_id')
                  ->nullable(false)
                  ->change();

            // Revert enum
            $table->enum('payment_status', [
                    'created',
                    'paid',
                    'failed',
                    'refunded'
                ])
                ->default('created')
                ->change();

        });
    }

};