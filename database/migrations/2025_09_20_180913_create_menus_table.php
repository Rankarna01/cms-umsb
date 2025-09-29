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
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: Menu Header Utama
        $table->string('location')->unique(); // Contoh: header
        $table->timestamps();
    });
}
};
