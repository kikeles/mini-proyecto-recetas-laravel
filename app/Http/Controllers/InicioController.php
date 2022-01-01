<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        //Mostrar recetas por cantida de votos 
        // $votadas = Receta::has('likes', '>', 1)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();
        
        //Obtener las recetas mas nuevas 
        //latest() = orderBy('created_at', 'ASC') o oldest() = orderBy('created_at', 'DESC')
        $nuevas = Receta::latest()->take(6)->get();
        
        //Obtener todas la categorias
        $categorias = CategoriaReceta::all();

        //Agrupar las recetas por categoria
        $recetas = [];
        foreach($categorias as $categoria){
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->take(3)->get();
        }
        
        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
