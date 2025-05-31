@csrf
<div class="mb-3">
    <label class="form-label">Nombre *</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Precio (COP) *</label>
        <input type="number" name="price" step="0.01" class="form-control"
               value="{{ old('price', $product->price ?? 0) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Stock *</label>
        <input type="number" name="stock" class="form-control"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Imagen {{ isset($product) ? '(opcional)' : '' }}</label>
        <input type="file" name="image" class="form-control">
        @isset($product->image)
            <small class="text-muted d-block mt-1">Actual: {{ $product->image }}</small>
        @endisset
    </div>
</div>

<button class="btn btn-success">Guardar</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
