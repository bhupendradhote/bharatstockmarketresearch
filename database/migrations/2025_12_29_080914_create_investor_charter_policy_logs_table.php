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
        Schema::create('investor_charter_policy_logs', function (Blueprint $table) {
    $table->id();

    $table->foreignId('policy_id')
        ->constrained('investor_charter_policies')
        ->cascadeOnDelete();

    $table->string('action'); // created, updated, archived, activated
    $table->text('remarks')->nullable();

    $table->foreignId('performed_by')->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_charter_policy_logs');
    }
};
