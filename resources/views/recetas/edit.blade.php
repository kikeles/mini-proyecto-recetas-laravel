@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/librerias.css') }}" rel="stylesheet">
@endsection

@section('botones')
    <a class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold" href="{{route('recetas.index')}}">
        <svg class="icono" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd"></path></svg>
        Volver</a>
@endsection

@section('content')
    {{-- {{$receta}} --}}
    <h2 class="text-center mb-5">Editar Receta: {{$receta->titulo}}</h1>
    
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form method="POST" action="{{ route('recetas.update', ['receta'=>$receta->id]) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">Título receta</label>
                    <input type="text"
                        name="titulo"
                        class="form-control @error('titulo') is-invalid @enderror"
                        id="titulo"
                        placeholder="Título de la receta"
                        value="{{$receta->titulo}}"
                    />
                    @error('titulo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select 
                        name="categoria"
                        id="categoria" 
                        class="form-control @error('categoria') is-invalid @enderror"
                    >
                        <option value="">-- Seleccione --</option>
                        @foreach($categorias as $categoria)
                            <option 
                                value="{{$categoria->id}}" 
                                {{$receta->categoria_id == $categoria->id ? 'selected' : ''}}>
                                {{$categoria->nombre}}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preparacion">Preparación</label>
                    <input 
                        type="hidden" 
                        id="preparacion" 
                        name="preparacion" 
                        value="{{ $receta->preparacion }}">
                    <trix-editor 
                    input="preparacion"
                    class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>

                    @error('preparacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ingredientes">Ingredientes</label>
                    <input 
                    type="hidden" 
                    id="ingredientes" 
                    name="ingredientes" 
                    value="{{ $receta->ingredientes }}">
                    <trix-editor 
                    input="ingredientes"
                    class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>

                    @error('ingredientes')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="imagen">Elige una imagen</label>
                    <input 
                        type="file" 
                        id="imagen"
                        class="form-control @error('imagen') is-invalid @enderror"
                        name="imagen">
                    
                    @error('imagen')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    
                    <div class="mt-4">
                        <p>Imagen Actual: </p>
                        <img src="/storage/{{$receta->imagen}}" alt="Imagen de la receta" width="300px">
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit"
                        class="btn btn-primary"
                        value="Agregar Receta"
                    />
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/librerias.js') }}" defer></script>
@endsection