<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nidn')->unique()->nullable();
            $table->string('position')->nullable(); // Jabatan (mis. Ketua Prodi)
            $table->string('email')->unique()->nullable();
            $table->string('photo')->nullable();
            // Foreign keys, bisa null jika dosen tidak terikat prodi/fakultas tertentu
            $table->foreignId('faculty_id')->nullable()->constrained('faculties')->onDelete('set null');
            $table->foreignId('study_program_id')->nullable()->constrained('study_programs')->onDelete('set null');
            $table->text('expertise')->nullable(); // Keahlian
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};