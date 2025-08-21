@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>💰 Gestión de Descuentos</h2>
                <a href="{{ route('admin.discounts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Descuento
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Porcentaje</th>
                                    <th>Usos Límite</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $discount->codigo }}</span>
                                    </td>
                                    <td>{{ $discount->nombre }}</td>
                                    <td>
                                        @if($discount->esGlobal())
                                            <span class="badge bg-success">🌍 Global</span>
                                        @elseif($discount->esPorCategoria())
                                            <span class="badge bg-info">📂 {{ $discount->categoria->name ?? 'Categoría' }}</span>
                                        @elseif($discount->esPorProducto())
                                            <span class="badge bg-warning">🥩 {{ $discount->producto->name ?? 'Producto' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $discount->porcentaje }}%</strong>
                                    </td>
                                    <td>
                                        {{ $discount->numero_descuentos ?? 'Ilimitado' }}
                                    </td>
                                    <td>
                                        {{ $discount->created_at->format('d/m/Y H:i') }}
                                    </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" 
                                            class="d-inline" onsubmit="return confirm('⚠️ ¿Estás seguro de eliminar este descuento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay descuentos creados aún</p>
                                        <a href="#" class="btn btn-primary">Crear primer descuento</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $discounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection