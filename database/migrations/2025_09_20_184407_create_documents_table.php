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
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('summary')->nullable();
        $table->foreignId('document_category_id')->constrained('document_categories')->onDelete('cascade');
        $table->string('file_path');
        $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}
};
