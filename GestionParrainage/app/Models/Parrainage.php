<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parrainage extends Model
{
    use HasFactory;

    protected $fillable = [
        'electeur_id',
        'candidat_id',
    ];

    public function electeur()
    {
        return $this->belongsTo(User::class, 'electeur_id');
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }
}
