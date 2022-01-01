<?php

namespace App\Providers;

use App\CategoriaReceta;
use View;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //comodin *, que significa que se le va a pasar a todas las categorias
        View::composer('*', function($view){
            $categorias = CategoriaReceta::all();
            $view->with('categorias', $categorias);            
        });
    }
}
