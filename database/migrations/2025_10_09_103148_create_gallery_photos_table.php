<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();

            // judul / keterangan singkat
            $table->string('title')->nullable();

            // path file di storage (mis. public/gallery/xxx.jpg)
            $table->string('image_path');

            // opsional: caption lebih panjang
            $table->text('caption')->nullable();

            // opsional: tanggal foto diambil
            $table->dateTime('taken_at')->nullable();

            // tampil / tidak
            $table->boolean('is_active')->default(true)->index();

            // untuk pengurutan manual
            $table->integer('sort_order')->default(0)->index();

            $table->timestamps();

            // index gabungan sering berguna untuk query urut aktif
            $table->index(['is_active', 'sort_order', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};
