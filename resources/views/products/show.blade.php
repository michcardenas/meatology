@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Imágenes del producto -->
       <div class="col-md-6">
    <div class="product-images">
        @if($product->images->count() > 0)
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                
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
                                 style="height: 500px; object-fit: cover;">
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
            <img src="{{ asset('images/placeholder.jpg') }}" 
                 class="img-fluid rounded" 
                 alt="{{ $product->name }}"
                 style="width: 100%; height: 500px; object-fit: cover;">
        @endif

        <!-- 🔥 NUEVA SECCIÓN: CERTIFICACIONES DEBAJO DEL CARRUSEL -->
        @if($product->certifications && $product->certifications->count() > 0)
            <div class="certifications-section mt-3">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    @foreach($product->certifications as $certification)
                        <div class="certification-item">
                            <img src="{{ Storage::url($certification->image) }}" 
                                 alt="Certification" 
                                 class="certification-badge"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#certificationModal{{ $certification->id }}"
                                 title="Click to view certification">
                        </div>

                        <!-- Modal para ver certificación en grande -->
                        <div class="modal fade" id="certificationModal{{ $certification->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-light">Product Certification</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ Storage::url($certification->image) }}" 
                                             alt="Certification" 
                                             class="img-fluid rounded"
                                             style="max-height: 70vh; object-fit: contain;">
                                        @if($certification->name)
                                            <h6 class="text-light mt-3">{{ $certification->name }}</h6>
                                        @endif
                                        @if($certification->description)
                                            <p class="text-light">{{ $certification->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <small class="text-light d-block text-center mt-2">
                    <i class="fas fa-certificate text-warning"></i> Product Certifications - Click to view
                </small>
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
                        $totalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
                    @endphp
                    <h3 class="text-success fw-bold">${{ number_format($totalPrice, 0, ',', '.') }}</h3>
<small class="text-white">/ {{ $product->avg_weight ?: 'per lb' }}</small>
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
         <!-- Sección de Productos Destacados con Fondo Verde Oscuro -->
<section class="py-5" style="background-color: #011904;">
    <div class="container">
        <!-- Encabezado -->
        <div class="row mb-5 text-center text-white">
            <div class="col">
                <span class="section-badge bg-light text-dark px-3 py-1 rounded-pill">🔥 Monthly Selection</span>
                <h2 class="section-title text-white mt-3">Featured Cuts of the Month</h2>
                <p class="section-description text-light">
                    Exclusive, hand-picked premium cuts curated for gourmet experiences.
                </p>
                <div class="section-divider mx-auto bg-success" style="height: 3px; width: 80px;"></div>
            </div>
        </div>

        <!-- Productos -->
        <div class="row g-4 mb-5">
            @foreach($featuredProducts->take(6) as $index => $product)
            <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #fdfdfd;">
                    
                    <div class="position-relative">
                        <!-- Imagen del producto -->
                        <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}"
                             class="card-img-top" alt="{{ $product->name }}"
                             style="height: 320px; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                        
                        <!-- Botón de Quick View -->
                      
                    </div>

                    <!-- Contenido -->
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold text-dark mb-2" style="font-family: 'Georgia', serif;">
                            {{ $product->name }}
                        </h4>

                        <!-- Descripción sin etiquetas HTML -->
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($product->description), 120) }}</p>

                        <!-- Layout vertical mejorado para precio y peso -->
                        <div class="d-flex flex-column align-items-start mt-4">
                            <div class="mb-2 d-flex align-items-center flex-wrap">
                                @php
                                    $totalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
                                @endphp
                                <span class="h5 text-success fw-bold me-3">${{ number_format($totalPrice, 0, ',', '.') }}</span>
                                
                                @if($product->stock <= 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge bg-warning text-dark">Limited Stock</span>
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </div>
                            
                            <!-- Mostrar avg_weight en línea separada y truncado -->
                            @if(!empty($product->avg_weight))
                                <small class="text-muted fw-medium">{{ Str::limit($product->avg_weight, 25) }}</small>
                            @endif
                        </div>

                        <!-- Formulario para agregar al carrito -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="d-flex gap-2">
                              <a href="{{ route('product.show', $product) }}" class="btn btn-outline-dark btn-sm rounded-pill flex-fill">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button type="submit" class="btn btn-buy btn-sm rounded-pill flex-fill" {{ $product->stock <= 0 ? 'disabled' : '' }}>
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
</section>

<!-- Product Details Section -->
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
    </ul>
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
            @foreach($featuredProducts as $featuredProduct)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card h-100 shadow-sm border-0 bg-dark text-light">
                    <div class="position-relative" style="overflow: hidden;">
                        <img src="{{ $featuredProduct->images->first() ? Storage::url($featuredProduct->images->first()->image) : asset('images/placeholder.jpg') }}" 
                             class="card-img-top" alt="{{ $featuredProduct->name }}"
                             style="height: 220px; object-fit: cover; transition: transform 0.3s ease;">
                        
                        <!-- Badge de categoría -->
                        @if($featuredProduct->category)
                            <span class="position-absolute top-0 start-0 badge bg-success m-2">
                                {{ $featuredProduct->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h6 class="card-title mb-2 text-light">{{ Str::limit($featuredProduct->name, 30) }}</h6>
                        <p class="card-text text-light small mb-2">
                            {{ Str::limit(strip_tags($featuredProduct->description), 80) }}
                        </p>
                        
                        <!-- Layout vertical para tarjetas pequeñas -->
                        <div class="mb-3">
                            <span class="text-success fw-bold d-block">
                                ${{ number_format(($featuredProduct->price ?? 0) + ($featuredProduct->interest ?? 0), 0, ',', '.') }}
                            </span>
                            @if(!empty($featuredProduct->avg_weight))
                                <small class="text-light" style="font-size: 0.75rem;">
                                    {{ Str::limit($featuredProduct->avg_weight, 20) }}
                                </small>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show', $featuredProduct) }}" 
                               class="btn btn-outline-light btn-sm flex-fill">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $featuredProduct->id }}">
                                <button type="submit" class="btn btn-success btn-sm w-100" 
                                        {{ $featuredProduct->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
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
.certifications-section {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    padding: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.certification-badge {
    width: 60px;
    height: 60px;
    object-fit: contain;
    background: white;
    border-radius: 8px;
    padding: 5px;
    border: 2px solid #e0e0e0;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.certification-badge:hover {
    transform: scale(1.1);
    border-color: #007bff;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.certification-item {
    position: relative;
}

/* Efecto hover para mostrar que es clicable */
.certification-item::after {
    content: '🔍';
    position: absolute;
    top: -5px;
    right: -5px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.certification-item:hover::after {
    opacity: 1;
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
        width: 50px;
        height: 50px;
    }
    
    .certifications-section {
        padding: 10px;
    }
}

/* 🔥 ESTILOS ESPECÍFICOS PARA FONDO VERDE OSCURO #013105 */
body {
    background-color: #013105;
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