<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $table = 'candidats';

    protected $fillable = [
        'user_id',
        'parti_politique',
        'slogan',
        'photo',
        'couleurs_parti',
        'url_candidat',
    ];

    /**
     * Relation : Un candidat appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Un candidat peut avoir plusieurs parrainages.
     */
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class, 'candidat_id');
    }
}
