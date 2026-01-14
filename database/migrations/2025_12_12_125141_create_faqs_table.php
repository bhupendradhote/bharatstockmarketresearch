<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();

            // Page Identification
            $table->string('page_type'); 
            // ex: home, about, service, blog, product

            $table->string('page_slug')->nullable(); 
            // ex: stock-tips, mutual-funds, about-us

            // FAQ Content
            $table->string('question');
            $table->text('answer')->nullable();

            // Controls
            $table->boolean('status')->default(true); 
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            // Optional index for fast query
            $table->index(['page_type', 'page_slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
