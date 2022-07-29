@extends('theme.template')

@section('content')
    
    <div class="container py-5 text-center">
        <h1> Listado de clientes </h1>
        <a href="{{ route('cliente.create') }}" class="btn btn-primary"> Crear cliente </a>

        @if (Session::has('mensaje'))
            <div class="alert alert-info my-5">
                {{Session::get('mensaje')}}
            </div>
        @endif

        <table class="table">
            <thead>
                <td>ID</td>
                <td>Nombre</td>
                <td>Saldo</td>
                <td>Comentarios</td>
                <td>Acciones</td>
            </thead>
            <tbody>
                @forelse ($clientes as $item)
                    <tr>
                        <td> {{ $item->id }} </td>
                        <td> {{ $item->name }} </td>
                        <td> {{ $item->due }} </td>
                        <td> {{ $item->comments }} </td>
                        <td> 
                            <a href="{{ route('cliente.edit', $item) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('cliente.destroy', $item) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td><p>No hay registros :(</p></td>
                    </tr>
                @endforelse
            </tbody>
        </table>`

        @if ($clientes->count())
            {{ $clientes->links() }}
        @endif

    </div>
@endsection