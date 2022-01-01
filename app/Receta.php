<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    //campos para la asignacion masiva de los datos de recetas
    protected $fillable = [
        'titulo', 'ingredientes', 'preparacion', 'imagen', 'categoria_id'
    ];

    //Obtiene la categoria de la receta via FK
    public function categoria(){
        return $this->belongsTo(CategoriaReceta::class);
    }

    //Obtiene la información del usuario via FK
    public function autor(){
        return $this->belongsTo(User::class, 'user_id');
    }

    //Likes que ha recibido una receta
    public function likes(){
        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
