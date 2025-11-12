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
        Schema::table('events', function (Blueprint $table) {
            // 1. Tambahkan kolom 'tanggal' yang baru
            // Kita taruh setelah 'description' agar rapi
            $table->date('tanggal')->nullable()->after('description');

            // 2. Hapus semua kolom lama yang tidak terpakai lagi
            // (Ini berdasarkan model lama Anda & form baru Anda)
            $table->dropColumn([
                'start_date',
                'end_date',
                'location',
                'contact_person'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     * (Untuk 'undo' jika terjadi kesalahan)
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // 1. Hapus kolom 'tanggal'
            $table->dropColumn('tanggal');

            // 2. Kembalikan kolom-kolom lama
            $table->unsignedBigInteger('category_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('location');
            $table->string('contact_person')->nullable();
            $table->string('registration_url')->nullable();
            $table->timestamp('published_at')->nullable();
        });
    }
};
