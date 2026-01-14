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
       Schema::create('investor_charter_policies', function (Blueprint $table) {
    $table->id();

    $table->string('title'); // Investor Charter
    $table->string('version'); // v1.0, v1.1, v2.0
    $table->date('effective_from');
    $table->date('effective_to')->nullable();

    $table->boolean('is_active')->default(false); 
    $table->boolean('is_archived')->default(false);

    $table->text('description')->nullable();

    $table->timestamps();

    $table->unique(['title', 'version']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_charter_policies');
    }
};
