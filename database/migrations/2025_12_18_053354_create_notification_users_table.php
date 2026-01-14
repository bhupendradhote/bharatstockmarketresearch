<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger('user_id');

            // 👁️ Read / Unread
            $table->timestamp('read_at')->nullable();

            // 🟢 Soft disable per user
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // ⚡ Indexes for performance
            $table->index(['user_id', 'read_at']);
            $table->index('notification_id');

            // 🔒 Foreign keys (safe for production)
            $table->foreign('notification_id')
                  ->references('id')
                  ->on('notifications')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_users');
    }
};
