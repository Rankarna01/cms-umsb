<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('leaders', function (Blueprint $table) {
        $table->string('social_facebook')->nullable()->after('photo');
        $table->string('social_instagram')->nullable()->after('social_facebook');
        $table->string('social_linkedin')->nullable()->after('social_instagram');
        $table->string('social_x')->nullable()->after('social_linkedin'); // Untuk Twitter/X
    });
}
};
