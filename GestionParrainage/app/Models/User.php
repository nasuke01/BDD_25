<?php
// app/Models/User.php (modifions le modèle existant)
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dateNaissance' => 'date',
        'password' => 'hashed',
    ];

    public function electeur()
    {
        return $this->hasOne(Electeur::class);
    }

    public function candidat()
    {
        return $this->hasOne(Candidat::class);
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }
}
