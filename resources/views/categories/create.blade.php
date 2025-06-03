@extends('layouts.app_admin')

@section('content')
<div class="container py-5 text-white">
    <h2 class="mb-4 text-warning">Agregar nueva categoría 🐄</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="bg-dark p-4 rounded">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-light">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label text-light">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-light">Imagen</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning text-dark fw-bold">Guardar Categoría</button>
    </form>
</div>
@endsection
