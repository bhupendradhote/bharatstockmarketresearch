<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderSettingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();

            // primary brand identity
            $table->string('website_name');                   
            $table->longText('logo_svg')->nullable();         

            // CTA Button
            $table->string('button_text')->default('Sign In');
            $table->string('button_link')->default('#');
            $table->boolean('button_active')->default(true);   

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
}
