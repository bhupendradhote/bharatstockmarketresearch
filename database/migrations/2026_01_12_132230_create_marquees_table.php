<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marquees', function (Blueprint $table) {
            $table->id();

            // Admin reference title (not shown on frontend)
            $table->string('title')->nullable();
            $table->string('description')->nullable();

            // Actual marquee / disclaimer text
            $table->text('content');

            // Control visibility
            $table->boolean('is_active')->default(true);

            // Optional scheduling
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            // If multiple marquees needed later
            $table->integer('display_order')->default(1);

            // Track admin changes
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marquees');
    }
};
