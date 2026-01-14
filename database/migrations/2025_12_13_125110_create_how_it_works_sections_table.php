<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('how_it_works_sections', function (Blueprint $table) {
            $table->id();

            // CONTENT
            $table->string('badge')->nullable();          
            $table->string('heading')->nullable();        
            $table->string('sub_heading')->nullable();    
            $table->text('description')->nullable();    
            // CTA
            $table->string('cta_text')->nullable();       
            $table->string('cta_url')->nullable();      
            // LAYOUT / UI
            $table->enum('alignment', ['left', 'center', 'right'])
                  ->default('center');

            // STATUS
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('how_it_works_sections');
    }
};
