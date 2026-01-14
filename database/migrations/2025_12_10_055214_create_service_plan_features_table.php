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
    Schema::create('service_plan_features', function (Blueprint $table) {
        $table->id();
        $table->foreignId('service_plan_duration_id')->constrained()->onDelete('cascade');

        $table->longText('svg_icon')->nullable();  // store <svg>...</svg>
        $table->string('text')->nullable();

        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('service_plan_features');
}

};
