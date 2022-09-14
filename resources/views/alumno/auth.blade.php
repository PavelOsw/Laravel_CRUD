@extends('theme.template')

@section('content')


<div>
    <h1>Alumno</h1>
    <div class="mb-3">
        <label for="name" class="form-label">Código</label>
        <input type="text" name="name" class="form-control" placeholder="Código">

        @error('name')
        <p class="form-text text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="due" class="form-label">NIP</label>
        <input type="number" name="due" class="form-control" placeholder="NIP">

        @error('due')
        <p class="form-text text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>
