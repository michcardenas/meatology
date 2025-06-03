@extends('layouts.app_admin')

@section('content')
<div class="container py-5 text-white">
    <h2 class="mb-4 text-warning">Categorías existentes</h2>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-4">➕ Nueva Categoría</a>

    <div class="row">
        @foreach($categories as $cat)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    @if ($cat->image)
                        <img src="{{ Storage::url($cat->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $cat->name }}</h5>
                        <p class="card-text">{{ Str::limit($cat->description, 100) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
