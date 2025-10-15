<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slide_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slide_id')
                ->constrained('slides')
                ->cascadeOnDelete(); // penting: hapus gambar saat slide dihapus
            $table->string('image_path'); // simpan path storage
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();

            $table->index(['slide_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slide_images');
    }
};
