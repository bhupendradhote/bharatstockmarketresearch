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
    Schema::table('tips', function (Blueprint $table) {
        // Tip ki category define karne ke liye
        $table->enum('tip_type', ['equity', 'future', 'option'])->default('equity')->after('id');
        
        // Future aur Option ke liye extra fields
        $table->date('expiry_date')->nullable()->after('cmp_price');
        $table->string('strike_price')->nullable()->after('expiry_date');
        $table->enum('option_type', ['CE', 'PE'])->nullable()->after('strike_price');
        
        // Target 2 field (kyunki blade mein Target 2 bhi hai)
        $table->decimal('target_price_2', 15, 2)->nullable()->after('target_price');
    });
}

public function down()
{
    Schema::table('tips', function (Blueprint $table) {
        $table->dropColumn(['tip_type', 'expiry_date', 'strike_price', 'option_type', 'target_price_2']);
    });
}
};
