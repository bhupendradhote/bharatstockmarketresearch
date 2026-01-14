<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // 🔔 Notification type
            $table->string('type');
            
            $table->string('reason')->nullable();

            // 📝 Content
            $table->string('title')->nullable();
            $table->text('message');

            // 🔗 Redirect URL (click action)
            $table->string('url')->nullable();

            // 👤 Sender (admin / system)
            $table->unsignedBigInteger('sender_id')->nullable();

            // 🧠 Extra data (JSON)
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};