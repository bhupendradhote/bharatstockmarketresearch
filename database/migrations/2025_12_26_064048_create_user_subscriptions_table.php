<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('service_plan_id')
                  ->constrained('service_plans')
                  ->cascadeOnDelete();

            $table->foreignId('service_plan_duration_id')
                  ->constrained('service_plan_durations')
                  ->cascadeOnDelete();

            // Subscription period
            $table->date('start_date');
            $table->date('end_date');

            // Status
            $table->enum('status', ['active', 'expired', 'cancelled'])
                  ->default('active');

            // Future ready
            $table->boolean('is_auto_renew')
                  ->default(false);

            // Dummy / real payment reference
            $table->string('payment_reference')
                  ->nullable();

            $table->timestamps();

            // Helpful index
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
