<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tips', function (Blueprint $table) {

            // 1️⃣ Ensure status column
            $table->enum('status', ['active', 'archived','cancel'])
                  ->default('active')
                  ->change();

            // 2️⃣ Version column
            $table->integer('version')
                  ->default(1)
                  ->after('status');

            // 3️⃣ Normal nullable parent_id (NO foreign key)
            $table->integer('parent_id')
                  ->nullable()
                  ->after('id');

            // 4️⃣ Index for versioning performance
            $table->index(
                ['parent_id', 'status', 'version', 'stock_name'],
            );
        });
    }

    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {


            // Drop columns
            $table->dropColumn(['version', 'parent_id']);

            // Revert status
            $table->string('status')->change();
        });
    }
};
