<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'numCarteElecteur',
        'dateNaissance',
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'type_utilisateur',
    ];

    public function candidat()
    {
        return $this->hasOne(Candidat::class, 'user_id');
    }
}
