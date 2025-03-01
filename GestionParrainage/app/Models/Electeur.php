<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    use HasFactory;

    protected $table = 'users'; // ⚠️ Les électeurs sont dans la table "users"

    protected $fillable = [
        'numCarteElecteur',
        'cin',
        'nom',
        'prenom',
        'dateNaissance',
        'email',
        'telephone',
        'password',
        'type_utilisateur', // ELECTEUR, CANDIDAT, ADMINISTRATEUR
    ];

    /**
     * Relation : Un électeur peut parrainer plusieurs candidats.
     */
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class, 'electeur_id');
    }
}
