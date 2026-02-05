<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->integer('times_used')->default(0);

            $table->timestamps();

            $table->unique(['coupon_id','user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_usages');
    }
};