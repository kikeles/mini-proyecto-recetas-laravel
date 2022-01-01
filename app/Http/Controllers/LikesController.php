<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request, Receta $receta)
    {
        //Helper toggle() "si ya tiene un meGusta lo va a quitar, si no lo tiene agrega el meGusta"
        //Almacena los likes de una receta
        return auth()->user()->meGusta()->toggle($receta);
    }
    
}
