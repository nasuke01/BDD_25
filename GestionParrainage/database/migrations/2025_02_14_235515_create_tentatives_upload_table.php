<?php
// database/migrations/XXXX_XX_XX_XXXXXX_create_tentatives_upload_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentatives_upload', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('fichier', 255);
            $table->string('status', 50);
            $table->text('erreurs_detectees')->nullable();
            $table->dateTime('date_tentative');
            $table->string('ip_address', 45);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tentatives_upload');
    }
};