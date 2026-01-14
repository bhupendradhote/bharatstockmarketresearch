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
      Schema::create('tip_plan_access', function (Blueprint $table) {
    $table->id();

    $table->foreignId('tip_id')
        ->constrained('tips')
        ->cascadeOnDelete();

    $table->foreignId('service_plan_id')
        ->constrained('service_plans')
        ->cascadeOnDelete();


    $table->timestamps();

    // ✅ FIXED UNIQUE INDEX
    $table->unique(
        ['tip_id', 'service_plan_id'],
        'tip_plan_unique'
    );
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tip_plan_access');
    }
};
