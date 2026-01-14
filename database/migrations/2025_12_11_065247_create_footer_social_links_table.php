<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_social_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');            // ex: Facebook, Instagram
            $table->string('icon')->nullable(); // ex: fa-facebook, mdi-instagram
            $table->string('url');              // full link
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_social_links');
    }
};
