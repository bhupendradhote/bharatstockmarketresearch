<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_campaigns', function (Blueprint $table) {
            $table->id();

            // Message content
            $table->string('title');                    // Heading
            $table->string('description')->nullable();  // Short summary
            $table->text('message')->nullable();        // Short push text
            $table->string('image')->nullable();          // 🔑 Image URL
            $table->longText('content');                // Full message (HTML / text)

            // UI type: info | success | warning | danger | offer
            $table->string('type', 20)->default('info');

            // Status & schedule
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable(); // optional scheduling
            $table->timestamp('ends_at')->nullable();   // auto-expire

            // Admin reference
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_campaigns');
    }
};
