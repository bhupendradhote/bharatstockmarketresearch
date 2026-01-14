<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. MASTER TABLE: Policy ki basic details ke liye
        Schema::create('policy_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Internal Name: e.g. "Privacy Policy"
            $table->string('slug')->unique();   // URL Slug: e.g. "privacy-policy"
            $table->string('title')->nullable(); // Page Title: e.g. "Our Commitment to Your Privacy"
            $table->text('description')->nullable(); // Short Intro/Meta Description
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        // 2. CONTENTS TABLE: Versions aur history store karne ke liye
        Schema::create('policy_contents', function (Blueprint $table) {
            $table->id();
            // Relationship with Master
            $table->foreignId('policy_master_id')
                  ->constrained('policy_masters')
                  ->onDelete('cascade');
            
            $table->longText('content');             // Pura HTML content editor se
            $table->text('updates_summary')->nullable(); // "What's New" highlights
            $table->integer('version_number')->default(1);
            $table->boolean('is_active')->default(false); // Sirf latest true rahega
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pehle contents delete hogi (dependency ki wajah se) phir master
        Schema::dropIfExists('policy_contents');
        Schema::dropIfExists('policy_masters');
    }
};