<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tips', function (Blueprint $table) {
            // Adding symbol_token after stock_name
            $table->string('symbol_token')->nullable()->after('stock_name');
        });
    }

    public function down()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn('symbol_token');
        });
    }
};