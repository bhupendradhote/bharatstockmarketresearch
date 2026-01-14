<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_counters', function (Blueprint $table) {
            $table->id();
            $table->string('value'); // 10+, 4.8/5, 1000+
            $table->string('description'); // text (line breaks allowed)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_counters');
    }
};
