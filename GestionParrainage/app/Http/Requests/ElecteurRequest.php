<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElecteurRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|unique:electeurs|min:13|max:13',
        ];
    }
}