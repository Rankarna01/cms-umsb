<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('slides', 'caption')) {
                $table->text('caption')->nullable()->after('title');
            }

            if (!Schema::hasColumn('slides', 'layout')) {
                $table->enum('layout', ['full_width', 'split'])->default('full_width')->after('caption');
            }

            if (!Schema::hasColumn('slides', 'link_url')) {
                $table->string('link_url')->nullable()->after('layout');
            }

            if (!Schema::hasColumn('slides', 'button_text')) {
                $table->string('button_text')->nullable()->after('link_url');
            }

            if (!Schema::hasColumn('slides', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('button_text')->index();
            }

            if (!Schema::hasColumn('slides', 'active')) {
                $table->boolean('active')->default(true)->after('sort_order')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            // Kamu bisa hapus kalau ingin revert, tapi biasanya dibiarkan aman
            if (Schema::hasColumn('slides', 'caption')) {
                $table->dropColumn('caption');
            }
            if (Schema::hasColumn('slides', 'layout')) {
                $table->dropColumn('layout');
            }
            if (Schema::hasColumn('slides', 'link_url')) {
                $table->dropColumn('link_url');
            }
            if (Schema::hasColumn('slides', 'button_text')) {
                $table->dropColumn('button_text');
            }
            if (Schema::hasColumn('slides', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
            if (Schema::hasColumn('slides', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
