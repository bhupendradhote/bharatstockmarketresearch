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
    Schema::create('service_plan_durations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('service_plan_id')->constrained()->onDelete('cascade');

        $table->string('duration');  // "1 Month", "3 Months", "Lifetime", etc.
        $table->decimal('price', 10, 2);

        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('service_plan_durations');
}

};
