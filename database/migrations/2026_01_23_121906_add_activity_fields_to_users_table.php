<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->timestamp('last_active_at')->nullable()->after('last_login_at');
            $table->unsignedInteger('login_count')->default(0)->after('last_active_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_login_at',
                'last_active_at',
                'login_count',
            ]);
        });
    }
};
