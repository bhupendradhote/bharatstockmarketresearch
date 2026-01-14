<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_why_platform_contents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                  ->constrained('about_why_platform_sections')
                  ->cascadeOnDelete();

            $table->text('content');                 // Paragraph text
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_why_platform_contents');
    }
};
