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
        Schema::create('master_notification_reads', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('master_notification_id');
    $table->unsignedBigInteger('user_id');

    $table->timestamp('read_at')->nullable();
    $table->timestamp('acknowledged_at')->nullable();

    $table->timestamps();

    $table->unique(['master_notification_id', 'user_id']);

    $table->index('user_id');
    $table->index('master_notification_id');

    $table->foreign('master_notification_id')
          ->references('id')->on('master_notifications')
          ->onDelete('cascade');

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
        Schema::dropIfExists('master_notification_reads');
    }
};
