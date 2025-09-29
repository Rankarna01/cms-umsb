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
    Schema::create('factoids', function (Blueprint $table) {
        $table->id();
        $table->string('label'); // Contoh: Jumlah Mahasiswa
        $table->string('value'); // Contoh: 5120
        $table->string('icon')->nullable(); // Class icon Font Awesome
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}
};
