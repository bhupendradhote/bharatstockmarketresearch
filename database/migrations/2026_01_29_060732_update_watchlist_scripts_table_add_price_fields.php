<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('watchlist_scripts', function (Blueprint $table) {
        $table->decimal('ltp', 15, 2)->default(0.00)->after('exchange');
        $table->decimal('net_change', 15, 2)->default(0.00)->after('ltp');
        $table->decimal('percent_change', 8, 2)->default(0.00)->after('net_change');
        $table->boolean('is_positive')->default(true)->after('percent_change');
    });
}

public function down()
{
    Schema::table('watchlist_scripts', function (Blueprint $table) {
        $table->dropColumn(['ltp', 'net_change', 'percent_change', 'is_positive']);
    });
}
};
