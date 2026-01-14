<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();


            // Optional: Store category type for quick access
            $table->string('package_type')->nullable();

            $table->string('name');
            $table->string('slug')->unique();

            $table->longText('description')->nullable();
            $table->json('features')->nullable();

            $table->decimal('amount', 10, 2);
            $table->integer('discount_percentage')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();

            $table->integer('trial_days')->nullable();
            $table->integer('duration')->nullable();
            $table->enum('validity_type', ['days', 'months', 'years'])->default('days');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true); // 1=active, 0=inactive

            $table->integer('max_devices')->default(1);
            $table->boolean('telegram_support')->default(false);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
