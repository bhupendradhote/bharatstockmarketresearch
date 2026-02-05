<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcement_notification_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('announcement_notification_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamp('read_at')->nullable();
            $table->boolean('is_seen')->default(false);

            $table->timestamps();

            // ✅ Short FK names
            $table->foreign('announcement_notification_id', 'ann_notif_id_fk')
                  ->references('id')
                  ->on('announcement_notifications')
                  ->onDelete('cascade');

            $table->foreign('user_id', 'ann_user_id_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // no duplicates
            $table->unique(
                ['announcement_notification_id', 'user_id'],
                'ann_notif_user_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_notification_users');
    }
};