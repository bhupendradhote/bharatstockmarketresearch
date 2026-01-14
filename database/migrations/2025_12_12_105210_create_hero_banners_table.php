<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroBannersTable extends Migration
{
    public function up()
    {
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();

            // Page Identifier
            $table->string('page_key')->nullable(); // home, about, service, contact

            // Text Fields
            $table->string('badge')->nullable();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();

            // Buttons
            $table->string('button_text_1')->nullable();
            $table->string('button_link_1')->nullable();

            $table->string('button_text_2')->nullable();
            $table->string('button_link_2')->nullable();

            // Media
            $table->string('background_image')->nullable();
            $table->string('mobile_background_image')->nullable();

            // Styling
            $table->string('overlay_color')->nullable()->default('#000000');
            $table->string('text_color')->nullable()->default('#ffffff');
            $table->string('alignment')->nullable()->default('left'); // left, center, right
            $table->string('vertical_position')->nullable()->default('center'); // top, center, bottom
            $table->decimal('overlay_opacity', 4, 2)->nullable()->default(0.3);

            // Layout Controls
            $table->boolean('show_badge')->nullable()->default(true);
            $table->boolean('show_buttons')->nullable()->default(true);

            // Ordering & Status
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(true);

            // Advanced Settings (JSON)
            $table->json('settings')->nullable(); 
            // future options:
            // animation, parallax, mobile-specific styling, custom CSS, padding etc.

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_banners');
    }
}
