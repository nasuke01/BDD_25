<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temp_controle_electeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tentative_upload_id')->constrained('tentatives_upload')->onDelete('cascade');
            $table->string('cin')->nullable();
            $table->string('numCarteElecteur')->nullable();
            $table->text('probleme')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_controle_electeurs');
    }
};
