    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                
                // 1. Core Content
                $table->unsignedBigInteger('category_id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('short_description')->nullable(); // News Summary/Snippet
                $table->longText('content');
                $table->json('content_json')->nullable(); // For Editor.js or Block editors
                
                // 2. News Specific Features
                $table->enum('news_type', ['regular', 'breaking', 'exclusive', 'live'])->default('regular');
                $table->string('location')->nullable(); // City/Region for local news
                $table->string('source_name')->nullable(); // Example: PTI, Reuters, ANI
                $table->string('source_url')->nullable();  // Original source link
                $table->string('video_url')->nullable();   // YouTube/Vimeo link for video news
                
                // 3. SEO & Metadata
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->json('meta_keywords')->nullable();
                $table->string('canonical_url')->nullable();
                
                // 4. Status & Visibility
                $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft');
                $table->boolean('is_featured')->default(false); // Headline news
                $table->boolean('is_trending')->default(false); // Sidebar trending
                $table->boolean('allow_comments')->default(true);
                $table->integer('priority_weight')->default(0); // For sorting (1-10)
                
                // 5. Analytics & Scheduling
                $table->integer('view_count')->default(0);
                $table->integer('share_count')->default(0);
                $table->integer('reading_time')->default(0); // In minutes
                $table->timestamp('published_at')->nullable();
                $table->timestamp('scheduled_for')->nullable();
                
                // 6. Others
                $table->json('table_of_contents')->nullable();
                $table->softDeletes(); // For Trash system
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('news');
        }
    };