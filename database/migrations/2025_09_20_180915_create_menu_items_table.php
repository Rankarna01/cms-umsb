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
    Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
        $table->string('label'); // Teks yang tampil (misal: "Beranda")
        $table->string('url'); // Link (misal: "/")
        $table->string('target')->default('_self'); // _self atau _blank
        $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade'); // Untuk sub-menu
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}
};
