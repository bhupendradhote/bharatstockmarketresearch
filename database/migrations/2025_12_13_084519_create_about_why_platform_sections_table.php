<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_why_platform_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge', 150)->nullable();
            $table->text('heading');
            $table->string('image')->nullable();
            $table->string('subheading', 200)->nullable();
            $table->text('closing_text')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_why_platform_sections');
    }
};
