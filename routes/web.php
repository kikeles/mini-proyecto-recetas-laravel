<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Vista de página de invitado
Route::get('/', 'InicioController@index')->name('inicio.index');

//Rutas login y register
Auth::routes();

//Rutas para las recetas
Route::get('/recetas', 'RecetaController@index')->name('recetas.index');
Route::get('/recetas/create', 'RecetaController@create')->name('recetas.create');
Route::post('/recetas/store', 'RecetaController@store')->name('recetas.store');
Route::get('/recetas/{receta}', 'RecetaController@show')->name('recetas.show');
Route::get('/recetas/{receta}/edit', 'RecetaController@edit')->name('recetas.edit');
Route::put('/recetas/{receta}', 'RecetaController@update')->name('recetas.update');
Route::delete('/recetas/{receta}', 'RecetaController@destroy')->name('recetas.destroy');

//Buscador de una receta
Route::get('/buscar', 'RecetaController@search')->name('buscar.show');

//Mostrar las recetas por categoria
Route::get('/categoria/{categoriaReceta}','CategoriasController@show')->name('categorias.show');

//Perfiles
Route::get('/perfiles/{perfil}', 'PerfilController@show')->name('perfiles.show');
Route::get('/perfiles/{perfil}/edit', 'PerfilController@edit')->name('perfiles.edit');
Route::put('/perfiles/{perfil}', 'PerfilController@update')->name('perfiles.update');

//Almacena los likes de las recetas
Route::post('/recetas/{receta}', 'LikesController@update')->name('likes.update');


