<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('how_it_works_steps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained('how_it_works_sections')
                ->cascadeOnDelete();

            // CONTENT
            $table->string('short_title')->nullable();    
            $table->string('title')->nullable();          
            $table->text('description')->nullable();       
            $table->string('highlight_text')->nullable();  

            // ICON (NOT IMAGE)
            $table->string('icon')->nullable();           

            // STEP CTA
            $table->string('link_text')->nullable();       
            $table->string('link_url')->nullable();

            // STATUS
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('how_it_works_steps');
    }
};
