<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('why_choose_sections', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable(); 
            $table->string('badge')->nullable();
            $table->string('heading')->nullable();
            $table->text('description')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_sections');
    }
};
