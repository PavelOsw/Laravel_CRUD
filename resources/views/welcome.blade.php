@extends('theme.template')

@section('content')
    
    <div class="container py-5 text-center">
        <h1> Hola mundo! :) </h1>
        <a href="{{ route('cliente.index') }}" class="btn btn-primary"> Clientes </a>
    </div>
@endsection