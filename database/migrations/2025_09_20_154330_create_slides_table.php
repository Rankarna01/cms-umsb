<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('caption')->nullable();
            // 'full_width' atau 'split'
            $table->enum('layout', ['full_width', 'split'])->default('full_width');
            $table->string('link_url')->nullable();
            $table->string('button_text')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
