<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_key_feature_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained('home_key_feature_sections')
                ->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_key_feature_items');
    }
};
