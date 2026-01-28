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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        
        // Link to User (Important for Admin to know whose certificate it is)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Certificate Information (All Nullable)
        $table->string('certificate_name')->nullable(); // e.g. "ISO 9001", "Best Employee"
        $table->string('certificate_number')->nullable();
        $table->string('issued_by')->nullable(); // Organiser or Authority
        $table->date('issue_date')->nullable();
        $table->date('expiry_date')->nullable();
        
        // File Attachment (Nullable)
        $table->string('file_path')->nullable(); 
        $table->string('file_extension')->nullable(); // pdf, jpg, etc.
        
        // Status and Description
        $table->text('description')->nullable();
        $table->enum('status', ['active', 'expired', 'revoked', 'pending'])->default('active')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
