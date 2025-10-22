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
    Schema::create('testimonials', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('graduation_year')->nullable();
        $table->string('occupation')->nullable();
        $table->string('photo')->nullable();
        $table->text('content');
        $table->boolean('active')->default(true);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}
};
