<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->index(); // e.g., 'Features', 'Service Update'
            $table->text('content');         // The short summary shown in the list
            $table->longText('detail');      // The full content shown on the right
            $table->timestamp('published_at')->useCurrent(); // For "Today", "2 days ago" logic
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
