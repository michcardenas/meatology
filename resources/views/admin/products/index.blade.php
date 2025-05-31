@extends('layouts.app_admin')

@section('content')
<style>
   
    
</style>

<div class="container py-4">
    <h2 class="mb-4 text-warning">📦 Productos</h2>

    @include('admin.products._flash')

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
        + Nuevo producto
    </a>

    @if($products->count())
        <div class="table-responsive rounded">
            <table class="table  table-custom align-middle">
                <thead>
                    <tr>
                        <th style="width:90px">Imagen</th>
                        <th>Nombre</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->image ? asset('storage/'.$p->image) : asset('images/placeholder.jpg') }}"
                                     class="img-fluid rounded" style="height:60px;object-fit:cover">
                            </td>
                            <td>{{ $p->name }}</td>
                            <td class="text-end">${{ number_format($p->price, 0) }}</td>
                            <td class="text-center">{{ $p->stock }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-white">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-muted">Aún no hay productos.</p>
    @endif
</div>
@endsection
