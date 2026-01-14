<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_campaign_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('message_campaign_id');
            $table->unsignedBigInteger('user_id');

            // Tracking
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('seen_at')->nullable();

            // sent | seen
            $table->string('status', 20)->default('sent');

            $table->timestamps();

            // Relations
            $table->foreign('message_campaign_id')
                ->references('id')
                ->on('message_campaigns')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // One campaign → one log per user
            $table->unique(['message_campaign_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_campaign_logs');
    }
};
