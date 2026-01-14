<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            
            // Basic Fields
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Design (News portal me categories colorful hoti hain)
            $table->string('color_code')->default('#4f46e5'); // Hex code for labels
            $table->string('icon')->nullable(); // For menu icons
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('order_priority')->default(0); // Kaunsi category pehle dikhegi
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_categories');
    }
};