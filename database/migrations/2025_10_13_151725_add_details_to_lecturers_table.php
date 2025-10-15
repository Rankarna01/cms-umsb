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
    Schema::table('lecturers', function (Blueprint $table) {
        $table->string('nik')->nullable()->after('nidn');
        $table->string('nbm')->nullable()->after('nik');
        $table->string('functional_position')->nullable()->after('position'); // Jabatan Fungsional
        $table->string('link_pddikti')->nullable()->after('expertise');
        $table->string('link_sinta')->nullable()->after('link_pddikti');
        $table->string('link_scholar')->nullable()->after('link_sinta');
    });
}
};
