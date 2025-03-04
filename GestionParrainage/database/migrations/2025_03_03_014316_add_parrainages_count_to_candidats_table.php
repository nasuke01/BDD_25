<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->integer('parrainages_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->dropColumn('parrainages_count');
        });
    }
};
