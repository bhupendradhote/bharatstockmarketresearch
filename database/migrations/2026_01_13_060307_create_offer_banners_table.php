<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offer_banners', function (Blueprint $table) {
            $table->id();

            // Basic Content
            $table->string('slug', 150)->unique();
            $table->string('heading');
            $table->string('sub_heading')->nullable();
            $table->text('content');
            $table->string('highlight_text')->nullable();

            // Button 1 (Primary CTA)
            $table->string('button1_text', 100);
            $table->string('button1_link');
            $table->enum('button1_target', ['_self', '_blank'])->default('_self');

            // Button 2 (Secondary CTA)
            $table->string('button2_text', 100);
            $table->string('button2_link');
            $table->enum('button2_target', ['_self', '_blank'])->default('_self');

            // Display & Control
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->enum('device_visibility', ['all', 'desktop', 'mobile'])->default('all');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            // Tracking (Optional but useful)
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('click_count')->default(0);

            // Admin tracking
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys (optional but recommended)
            // $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_banners');
    }
};
