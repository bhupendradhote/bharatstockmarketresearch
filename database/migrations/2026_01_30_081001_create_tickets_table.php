<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('subject');
            $table->string('issue');
            $table->text('description');
            $table->text('admin_note')->nullable();

            $table->enum('priority', ['Low','Medium','High'])->default('Low');

            // 👇 Default now In Progress (not Open)
            $table->enum('status', ['In Progress','Open','Resolved'])
                  ->default('In Progress');

            // ⏱ Time tracking
            $table->timestamp('opened_at')->nullable();   // when admin opens
            $table->timestamp('resolved_at')->nullable();

            $table->integer('resolution_days')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};