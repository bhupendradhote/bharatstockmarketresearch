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
        Schema::create('investor_charter_pages', function (Blueprint $table) {
    $table->id();

    $table->foreignId('policy_id')
        ->constrained('investor_charter_policies')
        ->cascadeOnDelete();

    $table->string('page_title'); // Rights of Investors, Services, Grievance etc
    $table->string('page_slug');
    $table->longText('content');

    $table->integer('page_order')->default(0);
    $table->boolean('is_visible')->default(true);

    $table->timestamps();

    $table->unique(['policy_id', 'page_slug']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_charter_pages');
    }
};
