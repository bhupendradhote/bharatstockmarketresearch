<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();

            // Page Info
            $table->string('page_type'); // home, about, services, contact
            $table->string('section_key')->nullable(); // hero, faq, cta

            // Content
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('badge')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable(); // Rich editor

            // Buttons
            $table->string('button_1_text')->nullable();
            $table->string('button_1_link')->nullable();
            $table->string('button_2_text')->nullable();
            $table->string('button_2_link')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Control
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
