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
        // 1. Perbarui tabel 'announcements' (Pengumuman)
        Schema::table('announcements', function (Blueprint $table) {
            // Tambah kolom untuk gambar thumbnail (seperti di gambar detail)
            $table->string('thumbnail')->nullable()->after('content');
            
            // Tambah kolom untuk lampiran file dari modul Dokumen
            $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');
            
            // Hapus kolom attachment lama jika ada (opsional, tapi disarankan)
            // if (Schema::hasColumn('announcements', 'attachment')) {
            //     $table->dropColumn('attachment');
            // }
        });

        // 2. Perbarui tabel 'events' (Agenda)
        Schema::table('events', function (Blueprint $table) {
            // Kita ganti nama 'poster' menjadi 'thumbnail' agar seragam
            if (Schema::hasColumn('events', 'poster')) {
                $table->renameColumn('poster', 'thumbnail');
            } else if (!Schema::hasColumn('events', 'thumbnail')) {
                 $table->string('thumbnail')->nullable()->after('location');
            }
            
            // Tambah kolom untuk lampiran file dari modul Dokumen
            $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropColumn(['thumbnail', 'document_id']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropColumn('document_id');
            // Jika Anda mengganti nama 'poster', kembalikan
            if (Schema::hasColumn('events', 'thumbnail')) {
                $table->renameColumn('thumbnail', 'poster');
            }
        });
    }
};