@extends('layouts.app')

@section('content')
@dd($featuredProducts)

<!-- Hero Section -->
<section id="inicio" class="hero-carousel">
    <!-- Carrusel de Bootstrap más simple y robusto -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
        </div>
        
        <!-- Slides del carrusel -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item item1 active">
                <div class="hero-slide" style="background-image: url('{{ asset('images/carrusel1.png') }}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-content container">
                        <div class="row">
                            <div class="col-lg-8 ps-lg-5">
                                <h1>PREMIUM URUGUAYAN GRASS-FED ANGUS BEEF</h1>
                                <p class="lead mb-4">Experience the finest quality beef from family-owned farms in the pristine lands of Uruguay. Naturally and sustainably raised for exceptional flavor.</p>
                                <a href="#productos" class="btn btn-primary btn-lg">Shop Premium Cuts</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="hero-slide" style="background-image: url('{{ asset('images/carrusel2.png') }}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-content container">
                        <div class="row">
                            <div class="col-lg-8 ps-lg-5">
                                <h1>TASTE THE DIFFERENCE OF AUTHENTIC QUALITY</h1>
                                <p class="lead mb-4">From farm to table, our commitment to excellence ensures every cut delivers unmatched tenderness and rich, natural flavor.</p>
                                <a href="#calidad" class="btn btn-primary btn-lg">Discover Our Process</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="hero-slide" style="background-image: url('{{ asset('images/carrusel3.png') }}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-content container">
                        <div class="row">
                            <div class="col-lg-8 ps-lg-5">
                                <h1>SUSTAINABLE FARMING, EXCEPTIONAL RESULTS</h1>
                                <p class="lead mb-4">Our cattle roam freely on Uruguay's natural pastures, creating beef that's not only delicious but ethically and sustainably produced.</p>
                                <a href="#sostenibilidad" class="btn btn-primary btn-lg">Learn Our Values</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 4 -->
            <div class="carousel-item">
                <div class="hero-slide" style="background-image: url('{{ asset('images/carrusel4.png') }}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-content container">
                        <div class="row">
                            <div class="col-lg-8 ps-lg-5">
                                <h1>ELEVATE YOUR CULINARY EXPERIENCE</h1>
                                <p class="lead mb-4">Transform your dining moments with beef that represents generations of Uruguayan ranching tradition and uncompromising quality standards.</p>
                                <a href="#contacto" class="btn btn-primary btn-lg">Start Your Order</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Controles de navegación -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Sección de Productos Destacados -->
<section id="productos" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-4 fw-bold text-dark">Premium Cuts Selection</h2>
                <p class="lead text-muted">Discover our finest selection of premium Uruguayan beef cuts</p>
                <div class="divider mx-auto"></div>
            </div>
        </div>
        
        @if($featuredProducts && $featuredProducts->count() > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="product-card h-100">
                    <div class="product-image-container">
                        @if($product->images && $product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                 class="product-image" alt="{{ $product->name }}">
                        @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="product-image" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}" 
                                 class="product-image" alt="No image available">
                        @endif
                        
                        <div class="product-overlay">
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <button class="btn btn-outline-light btn-sm add-to-cart" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                        
                        @if($product->category)
                        <span class="product-category-badge">{{ $product->category->name }}</span>
                        @endif
                    </div>
                    
                    <div class="product-info">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="product-price-section">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock > 0)
                                <span class="stock-status in-stock">
                                    <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span class="stock-status out-of-stock">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Ver todos los productos -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                    View All Products <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="no-products-message">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No products available at the moment</h4>
                    <p class="text-muted">Please check back later for our premium beef selection.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Sección de Categorías -->
@if($categories && $categories->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-4 fw-bold text-dark">Shop by Category</h2>
                <p class="lead text-muted">Explore our different categories of premium beef cuts</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="category-card">
                    <div class="category-content">
                        <h4 class="category-title">{{ $category->name }}</h4>
                        <p class="category-count">{{ $category->products->count() }} products available</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="btn btn-outline-primary">
                            Explore {{ $category->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
/* Estilos para las tarjetas de productos */
.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: none;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.product-category-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(13, 110, 253, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.product-info {
    padding: 20px;
}

.product-title {
    font-weight: 600;
    margin-bottom: 8px;
    color: #2c3e50;
}

.product-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.4;
}

.product-price-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.product-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #dc3545;
}

.stock-status {
    font-size: 0.8rem;
    font-weight: 500;
}

.stock-status.in-stock {
    color: #28a745;
}

.stock-status.out-of-stock {
    color: #dc3545;
}

/* Estilos para categorías */
.category-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 40px 30px;
    border-radius: 12px;
    text-align: center;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-title {
    font-weight: 600;
    margin-bottom: 10px;
}

.category-count {
    opacity: 0.9;
    margin-bottom: 20px;
}

/* Divider personalizado */
.divider {
    width: 60px;
    height: 4px;
    background: #dc3545;
    margin: 20px auto;
}

/* Mensaje de no productos */
.no-products-message {
    padding: 60px 0;
}

/* Responsividad */
@media (max-width: 768px) {
    .product-actions {
        flex-direction: row;
    }
    
    .product-price-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad para agregar al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            
            // Aquí puedes implementar la lógica AJAX para agregar al carrito
            // Por ahora, mostraremos una alerta simple
            alert('Product added to cart! (Product ID: ' + productId + ')');
            
            // Ejemplo de implementación AJAX:
            /*
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Mostrar mensaje de éxito
                    alert('Product added to cart successfully!');
                } else {
                    alert('Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding product to cart');
            });
            */
        });
    });
});
</script>
@endpush