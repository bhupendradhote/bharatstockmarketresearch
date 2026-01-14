<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // uuid support
            $table->uuid('uuid')->nullable();

            // Morph relation: model name + id
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            // Collection name (thumbnail, images, files, etc.)
            $table->string('collection_name');

            // File names
            $table->string('name');
            $table->string('file_name');

            // File info
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');

            // JSON fields for Spatie processing
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');

            // Order inside collection
            $table->unsignedInteger('order_column')->nullable();

            $table->timestamps();

            // Improves performance when using morphTo
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
