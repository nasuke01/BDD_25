<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur connecté
     */
    public function profile()
    {
        dd(Auth::user()); 
        return view('profile', ['user' => Auth::user()]);
    }
}
