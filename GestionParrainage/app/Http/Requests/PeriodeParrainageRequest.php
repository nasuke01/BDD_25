<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodeParrainageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ];
    }
}