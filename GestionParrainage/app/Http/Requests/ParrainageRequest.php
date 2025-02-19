<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParrainageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'electeur_id' => 'required|exists:electeurs,id',
            'candidat_id' => 'required|exists:candidats,id',
        ];
    }
}