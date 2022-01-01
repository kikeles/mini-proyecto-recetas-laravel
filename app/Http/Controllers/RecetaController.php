<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class RecetaController extends Controller
{
    /*
        -----------Ver resultados en la terminal desde el controlador------------
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("Texto");
    */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = auth()->user();
        $recetas = Receta::where('user_id', $usuario->id)->paginate(3);
        return view('recetas.index')
            ->with('recetas', $recetas)
            ->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Obteniendo las categorias
        //sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        //con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['imagen']->store('upload-recetas', 'public'));

        $data = $request->validate([
            'titulo' => 'required|string|min:5',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image|max:500'
        ]);

        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

        //Resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();

        //almacenar datos con el facades DB
        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'ingredientes' => $data['ingredientes'],
        //     'preparacion' => $data['preparacion'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria']
        // ]);

        //Almacenar datos con el Modelo
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'ingredientes' => $data['ingredientes'],
            'preparacion' => $data['preparacion'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria']
        ]);

        //Redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //Algunos metodos para obtener una receta
        // $receta = Receta::find($receta);
        //$receta = Receta::findOrFail($receta);

        //Obtener si el usuario actual le gusta la receta y esta autenticado 
        $like = ( auth()->user() ) ? auth()->user()->meGusta->contains($receta->id) : false;
        
        //Pasa la cantidad de likes a la vista de la receta
        $likes = $receta->likes->count(); 

        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //Ejecutar el Policy para que no puedan ver una receta que no haya creado dicho usuario
        $this->authorize('view', $receta);

        //con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //Se hace la revisión con el policy creado (solo el usuario de esta receta)
        $this->authorize('update', $receta);

        $data = $request->validate([
            'titulo' => 'required|string|min:5',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'image|max:500'
        ]);

        //Asignar valores
        $receta->titulo = $data['titulo'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->preparacion = $data['preparacion'];
        $receta->categoria_id = $data['categoria'];

        //si el usuario sube una nueva imagen
        if(request('imagen')){
            //Eliminar la imagen del servidor
            $url_imagen = 'public/'.$receta->imagen;
            Storage::delete($url_imagen);

            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            //Resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            $receta->imagen = $ruta_imagen;
        }

        $receta->save();

        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {   
        //Se hace la revisión con el policy creado (solo el usuario de esta receta)
        $this->authorize('delete', $receta);
        //Eliminar la imagen del servidor
        $url_imagen = 'public/'.$receta->imagen;
        Storage::delete($url_imagen);
        //Eliminar información de la receta
        $receta->delete();

        return redirect()->action('RecetaController@index');
    }

    public function search(Request $request)
    {
        // $busqueda = $request['buscar'];
        $busqueda = $request->get('buscar');

        $recetas = Receta::where('titulo', 'like', '%'.$busqueda.'%')->paginate(3);
        $recetas->appends(['buscar'=>$busqueda]);

        return view('busquedas.show', compact('recetas', 'busqueda'));
    }

}
