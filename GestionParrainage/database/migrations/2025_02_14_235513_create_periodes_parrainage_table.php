<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periodes_parrainage', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('statut')->default(false); // false = Fermé, true = Ouvert
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodes_parrainage');
    }
};
