<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_create_post_categories_table.php

public function up(): void
{
    Schema::create('post_categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->enum('type', ['news', 'information'])->default('news');
        
        // Untuk relasi parent-child (subkategori)
        $table->foreignId('parent_id')->nullable()->constrained('post_categories')->onDelete('set null');

        $table->text('description')->nullable();
        $table->integer('sort_order')->default(0);
        $table->boolean('active')->default(true);
        $table->timestamps(); // akan membuat created_at dan updated_at
    });
}
};
