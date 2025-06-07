@csrf

<div class="mb-4">
    <label class="form-label fw-bold text-light">Product Name *</label>
    <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="form-label fw-bold text-light">Description</label>
    <textarea name="description" rows="3" class="form-control bg-dark text-light border-secondary">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <label class="form-label fw-bold text-light">Price  *</label>
        <input type="number" name="price" step="0.01" class="form-control bg-dark text-light border-secondary"
               value="{{ old('price', $product->price ?? 0) }}" required>
    </div>
    <div class="col-md-4 mb-4">
    <label class="form-label fw-bold text-light">Interest Price </label>
    <input type="number" name="interest" step="0.01" class="form-control bg-dark text-light border-secondary"
           value="{{ old('interest', $product->interest ?? '') }}" placeholder="Optional discounted price">
</div>


    <div class="col-md-4 mb-4">
        <label class="form-label fw-bold text-light">Stock *</label>
        <input type="number" name="stock" class="form-control bg-dark text-light border-secondary"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>

    <div class="col-md-4 mb-4">
        <label class="form-label fw-bold text-light">Avg. Weight</label>
        <input type="text" name="avg_weight" class="form-control bg-dark text-light border-secondary"
               value="{{ old('avg_weight', $product->avg_weight ?? '') }}" placeholder="e.g. 7 Lbs or 3.2 Kg">
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-bold text-light">Product Images</label>
    <input type="file" name="images[]" class="form-control bg-dark text-light border-secondary" multiple>
    
    @if(isset($product) && $product->images && $product->images->count() > 0)
        <small class="text-muted d-block mt-2 mb-3">
            Currently has {{ $product->images->count() }} image{{ $product->images->count() > 1 ? 's' : '' }}
        </small>
        
        <!-- Grid de imágenes existentes -->
        <div class="row mt-3" id="images-container">
            @foreach($product->images as $image)
                <div class="col-md-3 col-sm-4 col-6 mb-3" id="image-{{ $image->id }}">
                    <div class="position-relative border border-secondary rounded p-2" style="background-color: #1a1a1a;">
                        <!-- Imagen -->
                        <img src="{{ Storage::url($image->image) }}" 
                             class="img-fluid rounded mb-2" 
                             style="height: 120px; width: 100%; object-fit: cover;" 
                             alt="Product image">
                        
                        <!-- Botón de eliminar -->
                        <button type="button" 
                                class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-1"
                                onclick="deleteImageAjax({{ $image->id }})">
                            <span>🗑️</span> Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<div class="mb-4">
    <label class="form-label fw-bold text-light">Category *</label>
    <select name="category_id" class="form-select bg-dark text-light border-secondary" required>
        <option value="">-- Select a category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="d-flex justify-content-between mt-4">
    <button class="btn btn-success px-4">💾 Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</div>
