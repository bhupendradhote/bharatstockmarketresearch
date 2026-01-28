<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risk_reward_masters', function (Blueprint $table) {
            $table->id();

            $table->enum('calculation_type', ['percentage', 'price']);

            $table->decimal('target1_value', 10, 2);
            $table->decimal('target2_value', 10, 2)->nullable();
            $table->decimal('stoploss_value', 10, 2);

            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_reward_masters');
    }
};
