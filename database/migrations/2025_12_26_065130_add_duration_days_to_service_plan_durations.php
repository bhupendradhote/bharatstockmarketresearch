<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('service_plan_durations', function (Blueprint $table) {
            $table->integer('duration_days')->nullable()->after('duration');
        });
    }

    public function down(): void
    {
        Schema::table('service_plan_durations', function (Blueprint $table) {
            $table->dropColumn('duration_days');
        });
    }
};
