<?php
// database/migrations/XXXX_XX_XX_XXXXXX_create_users_table.php
// La migration users existe déjà mais nous la modifions
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('numCarteElecteur', 20)->unique();
            $table->date('dateNaissance');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 100)->unique();
            $table->string('telephone', 20)->unique();
            $table->string('password');
            $table->enum('type_utilisateur', ['ELECTEUR', 'CANDIDAT', 'ADMINISTRATEUR']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};