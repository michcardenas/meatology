@csrf

<div class="mb-3">
    <label class="form-label">Name *</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Price (COP) *</label>
        <input type="number" name="price" step="0.01" class="form-control"
               value="{{ old('price', $product->price ?? 0) }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Stock *</label>
        <input type="number" name="stock" class="form-control"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Product Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
        @if(isset($product) && $product->images)
            <small class="text-muted d-block mt-1">
                Currently has {{ $product->images->count() }} image{{ $product->images->count() > 1 ? 's' : '' }}
            </small>
        @endif
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Category *</label>
    <select name="category_id" class="form-select" required>
        <option value="">-- Select a category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<button class="btn btn-success">Save</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
