<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('slide_images', function (Blueprint $table) {
            // Pastikan kolom foreign key ada dan berelasi benar
            if (!Schema::hasColumn('slide_images', 'slide_id')) {
                $table->foreignId('slide_id')
                      ->constrained('slides')
                      ->cascadeOnDelete();
            }

            // Tambahkan kolom sort_order kalau belum ada
            if (!Schema::hasColumn('slide_images', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('image_path')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('slide_images', function (Blueprint $table) {
            if (Schema::hasColumn('slide_images', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
