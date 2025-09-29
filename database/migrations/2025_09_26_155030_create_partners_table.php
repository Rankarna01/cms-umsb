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
    Schema::create('partners', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->enum('type', ['kerjasama', 'media']);
        $table->string('logo')->nullable();
        $table->string('website_url')->nullable();
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}
};
