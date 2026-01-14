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
    Schema::create('inquiries', function (Blueprint $table) {
        $table->id();

        // If user is logged in - store user_id
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();

        $table->string('subject')->nullable();
        $table->text('message')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
