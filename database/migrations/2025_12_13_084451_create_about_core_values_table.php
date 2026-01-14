<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_core_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')
                  ->constrained('about_core_value_sections')
                  ->cascadeOnDelete();

            $table->string('icon', 100)->nullable(); // ✓ or fa-icon
            $table->string('title', 150);
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_core_values');
    }
};
