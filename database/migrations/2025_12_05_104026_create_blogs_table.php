<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Relation: Each blog belongs to one category
            $table->foreignId('category_id')
                ->constrained('blog_categories')
                ->cascadeOnDelete();

            // Basic fields
            $table->string('title');
            $table->string('slug')->unique();

            // Short excerpt for cards / SEO / listings
            $table->text('short_description')->nullable();

            // WYSIWYG HTML content
            $table->longText('content')->nullable();

            // Optional: If using Editor.js / Quill / Tiptap in JSON format
            $table->longText('content_json')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Auto-calculated reading time (minutes)
            $table->integer('reading_time')->nullable();

            // Featured on homepage / sliders
            $table->boolean('is_featured')->default(false);

            // Publishing controls
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();     // When it was published
            $table->timestamp('scheduled_for')->nullable();    // Future publishing

            // Statistics
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);

            // To improve SEO and avoid linking issues
            $table->string('canonical_url')->nullable();

            // Store auto-generated table of contents (h2, h3)
            $table->json('table_of_contents')->nullable();

            // Soft delete support (optional)
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
