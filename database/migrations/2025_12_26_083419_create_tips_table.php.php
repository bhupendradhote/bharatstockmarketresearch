<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tips', function (Blueprint $table) {
    $table->id();

    $table->string('stock_name');
    $table->string('exchange', 10); // NSE / BSE
    $table->string('call_type', 10); // BUY / SELL

    $table->foreignId('category_id')
        ->constrained('tip_categories')
        ->cascadeOnDelete();

    $table->decimal('entry_price', 10, 2);
    $table->decimal('target_price', 10, 2);
    $table->decimal('stop_loss', 10, 2);
    $table->decimal('cmp_price', 10, 2)->nullable();

    $table->string('status')->default('active'); 
    // active / target_hit / sl_hit / closed

    $table->text('admin_note')->nullable();

    $table->foreignId('created_by')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
