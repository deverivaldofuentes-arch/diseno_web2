<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Mostrar chat con IA
     */
    public function index()
    {
        return view('chat.index');
    }
}
