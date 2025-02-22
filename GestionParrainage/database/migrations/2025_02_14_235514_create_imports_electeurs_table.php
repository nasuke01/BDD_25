<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('electeurs_imports', function (Blueprint $table) {
            $table->id();
            $table->string('numCarteElecteur')->unique();
            $table->string('cin')->unique()->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->date('dateNaissance');
            $table->boolean('verifie')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electeurs_imports');
    }
};
