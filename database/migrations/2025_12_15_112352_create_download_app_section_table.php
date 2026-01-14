<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('download_app_section', function (Blueprint $table) {
            $table->id();

            $table->string('page_key')->index();

            // Section content
            $table->string('title')->nullable();      
            $table->string('heading')->nullable();     
            $table->text('description')->nullable();    

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // ✅ One section per page
            $table->unique('page_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('download_app_section');
    }
};
