<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('footer_brand_settings', function (Blueprint $table) {
        $table->id();

        // Main branding fields
        $table->string('title')->nullable();
        $table->longText('icon_svg')->nullable();
        $table->text('description')->nullable();

        // ⭐ Extra fields for future-proofing ⭐
        
        // Optional subtitle or tag line
        $table->string('subtitle')->nullable();

        // Allow multiple paragraphs or rich text
        $table->longText('content')->nullable();

        // Optional small note under description
        $table->string('note')->nullable();

        // Optional CTA button in footer brand area
        $table->string('button_text')->nullable();
        $table->string('button_link')->nullable();

        // Optional image/logo file path
        $table->string('image')->nullable();

        // Show/hide toggle
        $table->boolean('status')->default(1);

        // Sorting if you want multiple brand sections in future
        $table->integer('sort_order')->default(1);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_brand_settings');
    }
};
