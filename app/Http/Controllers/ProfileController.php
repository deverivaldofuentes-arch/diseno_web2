<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Mostrar perfil del usuario
     */
    public function index()
    {
        return view('profile.index');
    }
}
