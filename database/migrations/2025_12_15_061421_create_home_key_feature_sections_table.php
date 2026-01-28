<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding bsmr_id after 'id'
            // We use string to safely handle the concatenation, 
            // but BigInteger works if strictly numeric.
            $table->string('bsmr_id')->after('id')->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bsmr_id');
        });
    }
};
