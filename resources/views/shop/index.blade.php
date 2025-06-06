@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary-dark: #011904;
        --accent: #acafab;
        --highlight: #f7a831;
        --text-light: #e5e5e5;
        --bg-card: #112717;
    }

    body {
        background-color: var(--primary-dark);
        color: var(--text-light);
    }

    .catalog-title {
        color: var(--accent);
        font-weight: bold;
        font-size: 2.5rem;
    }

    .sidebar {
        background-color: #0a1a0f;
        padding: 20px;
        border-right: 1px solid #1c3825;
        color: var(--accent);
    }

    .sidebar h5 {
        font-size: 1rem;
        color: var(--accent);
        border-bottom: 1px solid #2b4a32;
        padding-bottom: 10px;
        margin-top: 20px;
    }

    .form-label,
    .form-select,
    input[type="number"] {
        background-color: #1c3825;
        border: none;
        color: var(--text-light);
    }

    .form-select:focus,
    input[type="number"]:focus {
        box-shadow: 0 0 0 0.25rem #acafab55;
    }

    .catalog-container {
        display: flex;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        padding-left: 30px;
        justify-items: center;
    }

    .product-card {
        background-color: var(--bg-card);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease;
        width: 100%;
        max-width: 300px;
    }

    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 0 10px #acafab33;
    }

    .product-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .product-info {
        padding: 15px;
    }

    .product-info h5 {
        color: var(--accent);
        margin-bottom: 10px;
    }

    .product-info p {
        color: #ccc;
        font-size: 0.9rem;
    }

    .product-price {
        font-size: 1.2rem;
        color: var(--highlight);
        font-weight: bold;
        margin-top: 10px;
    }

    .btn-buy {
        background-color: var(--highlight);
        color: #000;
        border: none;
        font-weight: bold;
        width: 100%;
    }

    .btn-buy:hover {
        background-color: #e69b1f;
    }
    .quick-view-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(1, 25, 4, 0.85); /* tono oscuro con transparencia */
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    font-weight: bold;
    font-size: 1.2rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.quick-view-btn {
    display: none;
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: var(--accent);
    color: var(--primary-dark);
    font-size: 0.9rem;
    font-weight: bold;
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    transition: all 0.3s ease;
    cursor: pointer;
    z-index: 2;
}

.product-card:hover .quick-view-btn {
    display: inline-block;
}

.quick-view-btn:hover {
    background-color: #cbd0e4;
    color: #000;
}
/* Estilos para el modal oscuro */
.modal-content {
    background-color: var(--primary-dark);
    border: 1px solid #1c3825;
    color: var(--text-light);
}

.modal-header {
    background-color: #0a1a0f;
    border-bottom: 1px solid #1c3825;
}

.modal-title {
    color: var(--accent);
    font-weight: bold;
}

.modal-body {
    background-color: var(--primary-dark);
}

.btn-close {
    filter: invert(1);
    opacity: 0.8;
}

.btn-close:hover {
    opacity: 1;
}

#quickViewName {
    color: var(--accent);
}

#quickViewDescription {
    color: #ccc;
}

#quickViewPrice {
    color: var(--highlight);
    font-weight: bold;
    font-size: 1.3rem;
}

/* Overlay del modal más oscuro */
.modal-backdrop {
    background-color: rgba(1, 25, 4, 0.8);
}

</style>


<div class="container-fluid py-5">
    <h1 class="text-center catalog-title mb-4">Meatology Catalog 🥩</h1>

    <div class="catalog-container">
        <!-- Sidebar -->
        <div class="sidebar col-md-3">
            <form method="GET" action="{{ route('shop.index') }}">
                <h5>Filter by Category</h5>
                <select name="category" class="form-select mb-3">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <h5>Filter by Price</h5>
                <div class="mb-3">
                    <label for="min_price" class="form-label text-light">Min:</label>
                    <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}">
                </div>
                <div class="mb-3">
                    <label for="max_price" class="form-label text-light">Max:</label>
                    <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}">
                </div>

                <button type="submit" class="btn btn-buy w-100">Apply Filters</button>
            </form>
        </div>

        <!-- Product Grid -->
        <div class="product-grid col-md-9">
            @forelse ($products as $product)
                <div class="product-card position-relative text-center">
             <div class="position-relative">
                <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}"
                    alt="{{ $product->name }}" class="img-fluid">

                <!-- Botón de Quick View -->
  <button class="quick-view-btn"
    data-bs-toggle="modal"
    data-bs-target="#quickViewModal"
    data-name="{{ $product->name }}"
    data-desc="{{ $product->description }}"
    data-price="{{ number_format($product->price, 0) }}"
    data-weight="{{ $product->avg_weight }}"
    data-stock="{{ $product->stock }}"
    data-category="{{ $product->category->name ?? 'N/A' }}"
    data-images="{{ $product->images->map(function($img) { return Storage::url($img->image); })->toJson() }}"
    data-id="{{ $product->id }}">
    Quick View
</button>
            </div>

                    <div class="product-info mt-3">
                        <h5 class="mb-1">{{ $product->name }}</h5>
                        <div class="product-price">${{ number_format($product->price, 0) }}</div>

                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="btn btn-buy">Add to Cart</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-light">No products found with the selected filters.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-5 text-center">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
<!-- Quick View Modal -->
<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewLabel">
                    <i class="fas fa-eye me-2"></i>Product Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna de la imagen con galería -->
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <!-- Imagen principal -->
                            <div class="main-image-container position-relative">
                                <img id="quickViewMainImage" src="" alt="Product Image" 
                                     class="img-fluid rounded shadow" 
                                     style="height: 350px; width: 100%; object-fit: cover; border: 2px solid var(--accent); transition: all 0.3s ease;">
                                
                                <!-- Badge de categoría -->
                                <span id="quickViewCategoryBadge" 
                                      class="position-absolute top-0 start-0 m-2 badge px-3 py-2"
                                      style="background-color: var(--highlight); color: #000; font-size: 0.9rem; display: none;">
                                </span>
                                
                                <!-- Contador de imágenes -->
                                <div id="imageCounter" class="position-absolute top-0 end-0 m-2 badge px-2 py-1"
                                     style="background-color: rgba(0,0,0,0.7); color: white; font-size: 0.8rem; display: none;">
                                </div>
                                
                                <!-- Botones de navegación (solo si hay múltiples imágenes) -->
                                <button id="prevImageBtn" class="btn btn-dark btn-sm position-absolute top-50 start-0 translate-middle-y ms-2"
                                        style="display: none; opacity: 0.8; z-index: 10;" onclick="changeImage(-1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button id="nextImageBtn" class="btn btn-dark btn-sm position-absolute top-50 end-0 translate-middle-y me-2"
                                        style="display: none; opacity: 0.8; z-index: 10;" onclick="changeImage(1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            
                            <!-- Thumbnails (solo si hay múltiples imágenes) -->
                            <div id="thumbnailContainer" class="mt-3" style="display: none;">
                                <div class="d-flex gap-2 justify-content-center flex-wrap" id="thumbnailImages">
                                    <!-- Los thumbnails se generarán dinámicamente -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna de información (sin cambios) -->
                    <div class="col-md-6">
                        <div class="d-flex flex-column h-100">
                            <!-- Título del producto -->
                            <div class="mb-3">
                                <h3 id="quickViewName" class="mb-2" style="color: var(--accent); font-weight: bold;">No name available</h3>
                                <div id="quickViewDescriptionContainer">
                                    <p id="quickViewDescription" class="mb-3" style="color: #ccc; line-height: 1.6;"></p>
                                </div>
                            </div>
                            
                            <!-- Información en cards -->
                            <div class="row mb-4">
                                <!-- Precio -->
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 rounded" style="background-color: var(--bg-card); border: 1px solid #1c3825;">
                                        <i class="fas fa-dollar-sign mb-2" style="color: var(--highlight); font-size: 1.2rem;"></i>
                                        <div class="fw-bold" style="color: var(--text-light); font-size: 0.9rem;">PRICE</div>
                                        <div id="quickViewPrice" class="fw-bold" style="color: var(--highlight); font-size: 1.4rem;">N/A</div>
                                    </div>
                                </div>
                                
                                <!-- Stock -->
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 rounded" style="background-color: var(--bg-card); border: 1px solid #1c3825;">
                                        <i class="fas fa-boxes mb-2" style="color: var(--accent); font-size: 1.2rem;"></i>
                                        <div class="fw-bold" style="color: var(--text-light); font-size: 0.9rem;">IN STOCK</div>
                                        <div id="quickViewStock" class="fw-bold" style="color: var(--accent); font-size: 1.4rem;">N/A</div>
                                    </div>
                                </div>
                                
                                <!-- Peso promedio -->
                                <div class="col-12" id="weightContainer" style="display: none;">
                                    <div class="text-center p-3 rounded" style="background-color: var(--bg-card); border: 1px solid #1c3825;">
                                        <i class="fas fa-weight mb-2" style="color: var(--text-light); font-size: 1.2rem;"></i>
                                        <div class="fw-bold" style="color: var(--text-light); font-size: 0.9rem;">AVG. WEIGHT</div>
                                        <div id="quickViewWeight" class="fw-bold" style="color: var(--text-light); font-size: 1.2rem;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botón de agregar al carrito -->
                            <div class="mt-auto">
                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" id="quickViewProductId">
                                    <button id="addToCartBtn" class="btn btn-buy w-100 py-3 fw-bold" style="font-size: 1.1rem;">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </form>
                                
                                <!-- Información adicional -->
                                <div class="text-center mt-3">
                                    <small style="color: #888;">
                                        <!-- <i class="fas fa-truck me-1"></i>Free shipping on orders over $50 -->
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
