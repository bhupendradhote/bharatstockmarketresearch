<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->json('followups')->nullable()->after('admin_note');
        });
    }

    public function down()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn('followups');
        });
    }
};
