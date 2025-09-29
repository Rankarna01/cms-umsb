// database/migrations/xxxx_xx_xx_xxxxxx_create_announcements_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            // Menggunakan tabel kategori yang sudah ada
            $table->foreignId('category_id')->nullable()->constrained('post_categories')->onDelete('set null');
            $table->string('attachment')->nullable(); // Path ke file lampiran
            $table->boolean('active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};