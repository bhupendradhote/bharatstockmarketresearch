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
        Schema::table('reviews', function (Blueprint $blueprint) {
            if (Schema::hasColumn('reviews', 'status')) {
                $blueprint->integer('status')->default(0)->comment('0:Pending, 1:Approved, 2:Rejected')->change();
            } else {
                $blueprint->integer('status')->default(0)->after('city');
            }

            $blueprint->boolean('is_featured')->default(false)->after('status');
            
            $blueprint->timestamp('approved_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['is_featured', 'approved_at']);
            // If you want to revert status, you can modify it back here
        });
    }
};