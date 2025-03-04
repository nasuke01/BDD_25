<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
     
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('numCarteElecteur')->unique();
            $table->string('cin')->unique()->nullable(); // CIN pour vérification
            $table->string('nom');
            $table->string('prenom');
            $table->date('dateNaissance');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('password');
            $table->enum('type_utilisateur', ['ELECTEUR', 'CANDIDAT', 'ADMINISTRATEUR'])->default('ELECTEUR');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
