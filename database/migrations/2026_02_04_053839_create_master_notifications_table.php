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
        Schema::create('master_notifications', function (Blueprint $table) {
    $table->id();

    $table->string('type', 50); 
    // chat, tip, popup, announcement, subscription, campaign, system, disaster, login, warning, success

    $table->string('severity', 20)->nullable(); 
    // critical, high, medium, low

    $table->string('title')->nullable();
    $table->text('message');

    $table->json('data')->nullable();

    $table->unsignedBigInteger('user_id')->nullable();
    $table->boolean('is_global')->default(false);

    $table->string('channel', 20)->default('database');
    // database, realtime, both

    $table->timestamp('expires_at')->nullable();

    $table->timestamps();

    $table->index('type');
    $table->index('user_id');
    $table->index('is_global');

    $table->foreign('user_id')
          ->references('id')->on('users')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_notifications');
    }
};
