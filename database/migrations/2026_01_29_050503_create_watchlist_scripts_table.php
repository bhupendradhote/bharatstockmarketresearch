<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_create_watchlist_scripts_table.php

public function up()
{
    Schema::create('watchlist_scripts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('watchlist_id')->constrained()->onDelete('cascade');
        $table->string('symbol');         // e.g., "RELIANCE-EQ"
        $table->string('trading_symbol')->nullable(); // e.g., "RELIANCE"
        $table->string('token')->nullable();          // Angel One Symbol Token
        $table->string('exchange')->default('NSE');   // NSE, BSE, MCX
        $table->timestamps();
        
        // Prevent duplicate scripts in the same watchlist
        $table->unique(['watchlist_id', 'symbol']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watchlist_scripts');
    }
};
