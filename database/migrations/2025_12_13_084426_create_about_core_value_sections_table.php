<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_core_value_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge', 100)->nullable();
            $table->string('title', 200);
            $table->string('subtitle', 200)->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_core_value_sections');
    }
};
