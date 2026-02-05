<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->enum('type', ['flat', 'percent']);
            $table->decimal('value', 10, 2);

            $table->decimal('min_amount', 10, 2)->nullable();

            $table->integer('global_limit')->nullable(); 
            $table->integer('used_global')->default(0);

            $table->integer('per_user_limit')->default(1);

            $table->date('expires_at')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};