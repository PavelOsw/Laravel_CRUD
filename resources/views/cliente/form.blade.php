@extends('theme.template')

@section('content')
    
    <div class="container py-5 text-center">
        @if (@isset($cliente))
            <h1> Editar cliente </h1>
        @else
            <h1> Crear cliente </h1>
        @endif

        @if (@isset($cliente))
            <form action="{{ route('cliente.update', $cliente) }}" method="post">
            @method('PUT')
        @else
            <form action="{{ route('cliente.store') }}" method="post">
        @endif

            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" placeholder="Nombre del cliente" value="{{old('name') ?? @$cliente->name }}">
                <p class="form-text">Escriba el nombre</p>

                @error('name')
                <p class="form-text text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due" class="form-label">Saldo</label>
                <input type="number" name="due" class="form-control" placeholder="Saldo del cliente" step="0.01" value="{{old('due') ?? @$cliente->due}}">
                <p class="form-text">Ingrese el saldo</p>

                @error('due')
                <p class="form-text text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="comments" class="form-label">Comentarios</label>
                <textarea name="comments" cols="30" rows="4" class="form-control"> {{old('comments') ?? @$cliente->comments }} </textarea>
                <p class="form-text">Escriba algunos comentarios</p>
            </div>

            @if (@isset($cliente))
                <button type="submit" class="btn btn-primary">Editar</button>
            @else
                <button type="submit" class="btn btn-primary">Guardar</button>
            @endif
        </form>

    </div>
@endsection