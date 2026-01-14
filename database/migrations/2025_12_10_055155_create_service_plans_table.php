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
    Schema::create('service_plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('tagline')->nullable();
        $table->boolean('featured')->default(0); // toggle
        $table->boolean('status')->default(1);   // toggle
        $table->integer('sort_order')->default(1);
        $table->string('button_text')->default('Subscribe Now');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('service_plans');
}

};
