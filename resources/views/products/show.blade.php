@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Imágenes del producto -->
       <div class="col-md-6">
    <div class="product-images">
        @if($product->images->count() > 0)
            <div id="productCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
                
                {{-- 🔥 Badge de Descuento --}}
                @if($product->descuento > 0)
                    <span class="position-absolute top-0 end-0 badge bg-danger m-3 fs-5" style="z-index: 10;">
                        -{{ $product->descuento }}% OFF
                    </span>
                @endif
                
                <!-- Indicadores tipo puntos -->
                <div class="carousel-indicators" style="bottom: 10px;">
                    @foreach($product->images as $index => $image)
                        <button type="button"
                                data-bs-target="#productCarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>

                <!-- Slides -->
                <div class="carousel-inner rounded" style="max-height: 500px; overflow: hidden;">
                    @foreach($product->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ Storage::url($image->image) }}"
                                 class="d-block w-100"
                                 alt="{{ $product->name }}"
                                 style="height: 500px; object-fit: fill;">
                        </div>
                    @endforeach
                </div>

                <!-- Controles -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @else
            <div class="position-relative">
                <img src="{{ asset('images/placeholder.jpg') }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}"
                     style="width: 100%; height: 500px; object-fit: cover;">
                
                {{-- 🔥 Badge de Descuento para imagen placeholder --}}
                @if($product->descuento > 0)
                    <span class="position-absolute top-0 end-0 badge bg-danger m-3 fs-5">
                        -{{ $product->descuento }}% OFF
                    </span>
                @endif
            </div>
        @endif

        <!-- 🔥 NUEVA SECCIÓN: CERTIFICACIONES DEBAJO DEL CARRUSEL -->
        @if($product->certification && count($product->certification) > 0)
            <div class="certifications-section mt-3">
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    @foreach($product->certification as $certNumber)
                        <div class="certification-item">
                            <img src="{{ asset('images/' . $certNumber . '.webp') }}"
                                 alt="Certification {{ $certNumber }}"
                                 class="certification-badge">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

        <!-- Información del producto -->
        <div class="col-md-6">
            <div class="product-info">
                <h1 class="mb-3" style="font-family: 'Georgia', serif;">{{ $product->name }}</h1>
                
                <div class="price-section mb-4">
                    @php
                        $basePrice = ($product->price ?? 0) + ($product->interest ?? 0);
                        $discountAmount = ($basePrice * ($product->descuento ?? 0)) / 100;
                        $finalPrice = $basePrice - $discountAmount;
                    @endphp
                    
                    @if($product->descuento > 0)
                        {{-- Precio original tachado --}}
                        <div class="text-muted text-decoration-line-through mb-1">
                            <span class="h5">${{ number_format($basePrice, 2, '.', ',') }}</span>
                        </div>
                        {{-- Precio con descuento --}}
                        <h3 class="text-danger fw-bold">${{ number_format($finalPrice, 2, '.', ',') }}</h3>
                        <small class="text-success fw-bold">You save: ${{ number_format($discountAmount, 2, '.', ',') }}</small>
                    @else
                        {{-- Precio normal --}}
                        <h3 class="text-success fw-bold">${{ number_format($basePrice, 2, '.', ',') }}</h3>
                    @endif
                    
                    <small class="text-white d-block">/ {{ $product->avg_weight ?: 'per lb' }}</small>
                </div>

                <div class="stock-info mb-4">
                    @if($product->stock <= 0)
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    @elseif($product->stock <= 5)
                        <span class="badge bg-warning text-dark fs-6">Limited Stock ({{ $product->stock }} left)</span>
                    @else
                        <span class="badge bg-success fs-6">In Stock ({{ $product->stock }} available)</span>
                    @endif
                </div>

          <div class="description mb-4">
    <h5>Description</h5>
    <div class="text-white">{!! $product->description !!}</div>
</div>

                <!-- Formulario para agregar al carrito -->
                @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="row g-3">
                        <div class="col-4">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="1" min="1" max="{{ $product->stock }}">
                        </div>
                        <div class="col-8 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
                @endif

                <!-- Botones adicionales -->
                <div class="d-flex gap-2 mb-4">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Shop
                    </a>
                    <button class="btn btn-outline-danger" onclick="toggleWishlist()">
                        <i class="fas fa-heart"></i> Add to Wishlist
                    </button>
                </div>

                <!-- Información adicional -->
         <div class="product-details">
                    <h6>Product Details</h6>
                    <ul class="list-unstyled">
                        <li><strong>SKU:</strong> #{{ $product->id }}</li>
                        <li><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</li>
                        @if(!empty($product->avg_weight))
                            <li><strong>Weight:</strong> {{ $product->avg_weight }}</li>
                        @endif
                        @if($product->pais)
                            <li><strong>Origin:</strong> {{ $product->pais }}</li>
                        @endif
                        @if($product->descuento > 0)
                            <li><strong>Discount:</strong> {{ $product->descuento }}% OFF</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos destacados/populares -->
  @if($featuredProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-star text-warning"></i> You Might Also Like
                <small class="text-white fs-6">Popular products</small>
            </h3>
            <div class="row g-4">
                @foreach($featuredProducts as $index => $featuredProduct)
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #fdfdfd;">

                        <div class="position-relative">
                            {{-- MEDIA CON CARRUSEL --}}
                            @php $imgs = $featuredProduct->images; @endphp
                            @if($imgs->count() > 1)
                                <a href="{{ route('product.show', $featuredProduct) }}" class="text-decoration-none">
                                    <div id="featuredCarousel-{{ $featuredProduct->id }}" class="carousel slide featured-product-carousel" data-bs-ride="false">
                                        <div class="carousel-inner">
                                            @foreach($imgs as $k => $img)
                                                <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                                                    <img src="{{ Storage::url($img->image) }}"
                                                         class="card-img-top"
                                                         alt="{{ $featuredProduct->name }}"
                                                         style="height: 320px; object-fit: fill; box-shadow: 0 4px 15px rgba(0,0,0,0.08);"
                                                         loading="lazy"
                                                         onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Controles del carrusel (solo visibles en hover) -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel-{{ $featuredProduct->id }}" data-bs-slide="prev" style="opacity: 0; transition: opacity 0.3s;">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel-{{ $featuredProduct->id }}" data-bs-slide="next" style="opacity: 0; transition: opacity 0.3s;">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>

                                        <!-- Indicadores del carrusel -->
                                        <div class="carousel-indicators" style="opacity: 0; transition: opacity 0.3s;">
                                            @foreach($imgs as $k => $img)
                                                <button type="button" data-bs-target="#featuredCarousel-{{ $featuredProduct->id }}" data-bs-slide-to="{{ $k }}" {{ $k === 0 ? 'class=active aria-current=true' : '' }} aria-label="Slide {{ $k + 1 }}"></button>
                                            @endforeach
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('product.show', $featuredProduct) }}" class="text-decoration-none">
                                    <img src="{{ $imgs->first()?->image ? Storage::url($imgs->first()->image) : asset('images/placeholder.jpg') }}"
                                         class="card-img-top" alt="{{ $featuredProduct->name }}"
                                         style="height: 320px; object-fit: fill; box-shadow: 0 4px 15px rgba(0,0,0,0.08);"
                                         loading="lazy">
                                </a>
                            @endif

                            {{-- Badge de Descuento --}}
                            @if($featuredProduct->descuento > 0)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2 fs-6">
                                    -{{ $featuredProduct->descuento }}% OFF
                                </span>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="card-body p-4" style="
    display: flex;
    flex-direction: column;
    justify-content: space-between;
">
                            <h4 class="card-title fw-bold text-dark mb-2" style="font-family: 'Georgia', serif;">
                                {{ $featuredProduct->name }}
                            </h4>

                            <!-- Descripción sin etiquetas HTML -->
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($featuredProduct->description), 120) }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    @php
                                        $basePrice = ($featuredProduct->price ?? 0) + ($featuredProduct->interest ?? 0);
                                        $discountAmount = ($basePrice * ($featuredProduct->descuento ?? 0)) / 100;
                                        $finalPrice = $basePrice - $discountAmount;
                                    @endphp

                                    {{-- Mostrar precio con o sin descuento --}}
                                    @if($featuredProduct->descuento > 0)
                                        {{-- Precio original tachado --}}
                                        <span class="text-muted text-decoration-line-through small">${{ number_format($basePrice, 2, '.', ',') }}</span>
                                        <br>
                                        {{-- Precio con descuento --}}
                                        <span class="h5 text-danger fw-bold">${{ number_format($finalPrice, 2, '.', ',') }}</span>
                                    @else
                                        {{-- Precio normal --}}
                                        <span class="h5 text-success fw-bold">${{ number_format($basePrice, 2, '.', ',') }}</span>
                                    @endif

                                    <!-- Mostrar avg_weight si existe, sino no mostrar nada -->
                                    @if(!empty($featuredProduct->avg_weight))
                                        <small class="text-muted">/ {{ $featuredProduct->avg_weight }}</small>
                                    @endif

                                    @if($featuredProduct->stock <= 0)
                                        <span class="badge bg-danger ms-2">Out of Stock</span>
                                    @elseif($featuredProduct->stock <= 5)
                                        <span class="badge bg-warning text-dark ms-2">Limited Stock</span>
                                    @else
                                        <span class="badge bg-success ms-2">Available</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Formulario para agregar al carrito -->
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $featuredProduct->id }}">
                                <div class="d-flex gap-2">
                                  <a href="{{ route('product.show', $featuredProduct) }}" class="btn btn-outline-dark btn-sm rounded-pill flex-fill">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button type="submit" class="btn btn-buy btn-sm rounded-pill flex-fill" {{ $featuredProduct->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
    <!-- Sección adicional: Últimos productos agregados -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="text-center">
                <h4 class="mb-3">Discover More Products</h4>
                <p class="text-white mb-4">Explore our complete collection of premium cuts</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-store"></i> Browse All Products
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.thumbnail-img:hover {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.card-img-top:hover {
    transform: scale(1.05);
}

.carousel-indicators [data-bs-target] {
    background-color: white;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.carousel-indicators .active {
    background-color: #198754; /* verde Bootstrap */
}

/* 🔥 ESTILOS PARA LAS CERTIFICACIONES */
/* .certifications-section {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    padding: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
} */

.certification-badge {
    width: 220px;
    height: 120px;
    object-fit: contain;
}

.certification-badge:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}


/* Estilos para el modal */
.modal-content {
    border: none;
    border-radius: 12px;
}

.modal-body img {
    border-radius: 8px;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .certification-badge {
        width: 90px;
        height: 90px;
    }
}

/* 🔥 ESTILOS ESPECÍFICOS PARA FONDO VERDE OSCURO #013105 */
body {
    background-color: #011904;
}

.certifications-section {
    color: #ffffff !important;
}

.certifications-section small {
    color: #e0e0e0 !important;
    font-weight: 500;
}

/* Asegurar que todos los textos sean visibles */
.text-white, .text-light {
    color: #ffffff !important;
}

.modal-content.bg-dark {
    background-color: #1a1a1a !important;
    border: 1px solid #333;
}

/* 🔥 ESTILOS PARA LAS TARJETAS EN FONDO VERDE OSCURO */
.card.bg-dark {
    background-color: #1a1a1a !important;
    border: 1px solid #333 !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
}

.card.bg-dark:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4) !important;
    transition: all 0.3s ease;
}

.card.bg-dark .card-title {
    color: #ffffff !important;
}

.card.bg-dark .card-text {
    color: #e0e0e0 !important;
}

.btn-outline-light {
    border-color: #ffffff;
    color: #ffffff;
}

.btn-outline-light:hover {
    background-color: #ffffff;
    color: #1a1a1a;
}

/* Badge de categoría con mejor contraste */
.badge.bg-success {
    background-color: #28a745 !important;
    color: #ffffff !important;
}
</style>

<script>
function toggleWishlist() {
    // Aquí puedes agregar la lógica para wishlist
    alert('Wishlist functionality - implement as needed');
}

// Cambiar imagen principal al hacer clic en thumbnails
document.querySelectorAll('.thumbnail-img').forEach(thumb => {
    thumb.addEventListener('click', function() {
        const mainImg = document.querySelector('.main-image img');
        mainImg.src = this.src;
    });
});
</script>
@endsection