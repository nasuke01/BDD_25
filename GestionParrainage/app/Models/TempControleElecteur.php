<?php

// app/Models/TempControleElecteur.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempControleElecteur extends Model
{
    protected $table = 'temp_controle_electeurs';
    
    protected $fillable = [
        'tentative_upload_id',
        'numCIN',
        'numElecteur',
        'probleme',
    ];

    public function tentativeUpload()
    {
        return $this->belongsTo(TentativeUpload::class);
    }
}