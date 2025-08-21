@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>✏️ Editar Descuento: {{ $discount->nombre }}</h4>
                    <a href="{{ route('admin.orders.discounts') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Información Básica --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del Descuento *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre', $discount->nombre) }}" 
                                       placeholder="Ej: Descuento de Bienvenida">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del Cupón *</label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                       id="codigo" name="codigo" value="{{ old('codigo', $discount->codigo) }}" 
                                       placeholder="Ej: WELCOME10" style="text-transform: uppercase;">
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3" 
                                      placeholder="Descripción opcional del descuento">{{ old('descripcion', $discount->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Configuración del Descuento --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="porcentaje" class="form-label">Porcentaje de Descuento *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('porcentaje') is-invalid @enderror" 
                                           id="porcentaje" name="porcentaje" value="{{ old('porcentaje', $discount->porcentaje) }}" 
                                           min="0" max="100" step="0.01" placeholder="10">
                                    <span class="input-group-text">%</span>
                                    @error('porcentaje')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="numero_descuentos" class="form-label">Límite de Usos</label>
                                <input type="number" class="form-control @error('numero_descuentos') is-invalid @enderror" 
                                       id="numero_descuentos" name="numero_descuentos" value="{{ old('numero_descuentos', $discount->numero_descuentos) }}" 
                                       min="1" placeholder="Deja vacío para ilimitado">
                                @error('numero_descuentos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tipo de Descuento --}}
                        <div class="mb-3">
                            <label class="form-label">Tipo de Descuento *</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_descuento" 
                                               id="tipo_global" value="global" 
                                               {{ old('tipo_descuento', $discount->esGlobal() ? 'global' : ($discount->esPorCategoria() ? 'categoria' : 'producto')) === 'global' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_global">
                                            🌍 <strong>Global</strong><br>
                                            <small class="text-muted">Aplica a todos los productos</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_descuento" 
                                               id="tipo_categoria" value="categoria" 
                                               {{ old('tipo_descuento', $discount->esGlobal() ? 'global' : ($discount->esPorCategoria() ? 'categoria' : 'producto')) === 'categoria' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_categoria">
                                            📂 <strong>Por Categoría</strong><br>
                                            <small class="text-muted">Aplica a una categoría específica</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_descuento" 
                                               id="tipo_producto" value="producto" 
                                               {{ old('tipo_descuento', $discount->esGlobal() ? 'global' : ($discount->esPorCategoria() ? 'categoria' : 'producto')) === 'producto' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_producto">
                                            🥩 <strong>Por Producto</strong><br>
                                            <small class="text-muted">Aplica a un producto específico</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('tipo_descuento')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Selección de Categoría --}}
                        <div class="mb-3" id="categoria_select" style="display: none;">
                            <label for="id_categoria" class="form-label">Seleccionar Categoría</label>
                            <select class="form-select @error('id_categoria') is-invalid @enderror" 
                                    id="id_categoria" name="id_categoria">
                                <option value="">-- Selecciona una categoría --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('id_categoria', $discount->id_categoria) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Selección de Producto --}}
                        <div class="mb-3" id="producto_select" style="display: none;">
                            <label for="id_producto" class="form-label">Seleccionar Producto</label>
                            <select class="form-select @error('id_producto') is-invalid @enderror" 
                                    id="id_producto" name="id_producto">
                                <option value="">-- Selecciona un producto --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ old('id_producto', $discount->id_producto) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.orders.discounts') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Descuento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="tipo_descuento"]');
    const categoriaSelect = document.getElementById('categoria_select');
    const productoSelect = document.getElementById('producto_select');
    
    // Función para mostrar/ocultar campos
    function toggleFields() {
        const selectedType = document.querySelector('input[name="tipo_descuento"]:checked')?.value;
        
        categoriaSelect.style.display = 'none';
        productoSelect.style.display = 'none';
        
        if (selectedType === 'categoria') {
            categoriaSelect.style.display = 'block';
        } else if (selectedType === 'producto') {
            productoSelect.style.display = 'block';
        }
    }
    
    // Agregar event listeners
    radioButtons.forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });
    
    // Ejecutar al cargar la página
    toggleFields();
    
    // Convertir código a mayúsculas automáticamente
    document.getElementById('codigo').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endsection