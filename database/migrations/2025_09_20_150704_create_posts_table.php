// database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->foreignId('category_id')->constrained('post_categories')->onDelete('cascade');
            $table->string('thumbnail')->nullable(); // Path ke gambar thumbnail
            $table->boolean('headline')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('hits')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};