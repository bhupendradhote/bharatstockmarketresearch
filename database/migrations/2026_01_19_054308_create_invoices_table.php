<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_subscription_id')->constrained()->cascadeOnDelete();

            $table->string('invoice_number')->unique();

            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('INR');

            $table->string('payment_gateway')->nullable();
            $table->string('payment_reference')->nullable();

            $table->date('invoice_date');
            $table->date('service_start_date');
            $table->date('service_end_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
