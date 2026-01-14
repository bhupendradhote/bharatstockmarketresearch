<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();

            // 🔹 Required
            $table->string('title');

            // 🔹 Optional Basic Info
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();

            // 🔹 Popup Type (controls UI)
            $table->enum('type', [
                'notification',
                'offer',
                'policy',
                'image',
                'custom'
            ])->nullable();

            // 🔹 Content Control
            $table->enum('content_type', [
                'text',
                'html',
                'image'
            ])->nullable();

            $table->longText('content')->nullable();   
            $table->string('image')->nullable();       

            // 🔹 CTA (optional)
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // 🔹 UI / UX
            $table->boolean('is_dismissible')->nullable()->default(true);

            // 🔹 Priority (optional)
            $table->integer('priority')->nullable()->default(0);

            // 🔹 SINGLE ACTIVE POPUP RULE
            $table->enum('status', ['active', 'inactive'])
                  ->nullable()
                  ->default('inactive')
                  ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
