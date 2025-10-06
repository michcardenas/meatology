@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
        color: #2c3e50;
        font-family: 'Inter', Arial, sans-serif;
    }

    .catalog-section {
        min-height: 100vh;
        padding: 40px 0;
        background-color: #ffffff;
    }

    .catalog-title {
        color: #011904;
        font-size: 2.2rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 40px;
    }

    /* Filtro Simple */
    .filter-bar {
        background: #ffffff;
        border: 1px solid #e0d9c0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 40px;
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-label {
        color: #011904;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .filter-select {
        background: #ffffff;
        border: 1px solid #e0d9c0;
        border-radius: 8px;
        color: #011904;
        padding: 8px 15px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2d5016;
        box-shadow: 0 0 0 2px rgba(45, 80, 22, 0.1);
    }

    /* Grid de Productos */
    .products-grid-3col {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 14px;
        overflow: hidden;
        min-height: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        border-color: #2d5016;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Media del producto */
    .pc-media {
        position: relative;
        overflow: hidden;
        background: #f8f9fa;
        height: 230px;
    }

    .pc-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .product-card:hover .pc-img {
        transform: scale(1.05);
    }

    /* Carrusel de productos */
    .product-carousel {
        height: 100%;
    }

    .product-carousel .carousel-inner {
        height: 100%;
    }

    .product-carousel .carousel-item {
        height: 100%;
        transition: transform 0.6s ease;
    }

    /* Body del producto */
    .pc-body {
        padding: 14px 14px 8px;
        color: #2c3e50;
        flex: 1 1 auto;
    }

    .pc-category {
        font-size: .78rem;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .pc-title {
        margin: 0 0 10px;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.25;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pc-title a {
        color: #011904;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .pc-title a:hover {
        color: #2d5016;
    }

    .pc-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-top: auto;
    }

    .pc-price {
        color: #2d5016;
        font-weight: 800;
        font-size: 1.15rem;
    }

    .pc-weight {
        color: #6c757d;
        font-size: .85rem;
    }

    /* Actions */
    .pc-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        padding: 12px 14px 16px;
        border-top: 1px solid #e0e0e0;
        flex-wrap: wrap;
    }

    .btn-ghost, .btn-solid {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        min-width: 130px;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s ease;
        cursor: pointer;
        font-size: .92rem;
        border: none;
    }

    /* Outline */
    .btn-ghost {
        color: #011904;
        background: transparent;
        border: 1px solid #011904;
    }

    .btn-ghost:hover {
        color: #ffffff;
        background: #011904;
        border-color: #011904;
        transform: translateY(-2px);
    }

    /* Solid */
    .btn-solid {
        color: #ffffff;
        background: #2d5016;
        border: 1px solid #2d5016;
    }

    .btn-solid:hover {
        background: #011904;
        border-color: #011904;
        transform: translateY(-2px);
    }

    /* Hero Section - VERSIÓN CLARA */
    .meatology-carousel-section {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8f4 100%);
        margin: 0;
        padding: 0;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-bottom: 0;
        height: 500px;
    }

    .category-hero-slide {
        position: relative;
        height: 100%;
        overflow: hidden;
    }

    .slide-background {
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        z-index: 1;
    }

    .slide-bg-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        opacity: 0.15;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0.95) 0%, 
            rgba(255, 255, 255, 0.85) 50%, 
            rgba(255, 255, 255, 0.6) 100%);
    }

    .slide-content {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        z-index: 2;
        padding: 40px 0;
    }

    .slide-text {
        color: #011904;
        padding-right: 40px;
    }

    .category-label {
        background: rgba(45, 80, 22, 0.1);
        border: 1px solid #2d5016;
        border-radius: 25px;
        padding: 8px 20px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        color: #2d5016;
    }

    .slide-title {
        font-size: 2.8rem;
        font-weight: 900;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        line-height: 1.1;
        color: #011904;
    }

    .slide-description {
        font-size: 1.1rem;
        margin-bottom: 25px;
        opacity: 0.9;
        line-height: 1.5;
        max-width: 450px;
        color: #2d5016;
    }

    .shop-category-btn {
        display: inline-block;
        background: #2d5016;
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(45, 80, 22, 0.3);
    }

    .shop-category-btn:hover {
        background: #011904;
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(1, 25, 4, 0.4);
        color: white;
        text-decoration: none;
    }

    .slide-image {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .category-product-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .category-product-image:hover {
        transform: scale(1.05);
    }

    /* Controles del carrusel */
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(45, 80, 22, 0.8);
        border: 2px solid rgba(45, 80, 22, 0.3);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .carousel-control-prev {
        left: 30px;
    }

    .carousel-control-next {
        right: 30px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background: #011904;
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
    }

    /* Indicadores */
    .carousel-indicators {
        bottom: 30px;
        margin-bottom: 0;
    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(45, 80, 22, 0.4);
        border: 2px solid rgba(45, 80, 22, 0.6);
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .carousel-indicators .active {
        background: #2d5016;
        border-color: #011904;
        transform: scale(1.2);
    }

    /* No products message */
    .no-products {
        text-align: center;
        color: #6c757d;
        font-size: 1.1rem;
        margin-top: 60px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .products-grid-3col {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .catalog-title {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .filter-bar {
            flex-direction: column;
            gap: 15px;
            padding: 15px;
        }

        .filter-group {
            width: 100%;
            justify-content: space-between;
        }

        .filter-select {
            min-width: 150px;
        }

        .pc-media {
            height: 200px;
        }

        .pc-body {
            padding: 15px;
        }

        .btn-ghost, .btn-solid {
            min-width: 100%;
        }

        .meatology-carousel-section {
            height: auto;
            min-height: 400px;
        }

        .slide-content {
            text-align: center;
            padding: 20px 0;
        }

        .slide-text {
            padding-right: 0;
            margin-bottom: 20px;
        }

        .slide-title {
            font-size: 2.2rem;
            letter-spacing: 1px;
        }

        .slide-description {
            margin: 0 auto 20px;
            font-size: 1rem;
            padding: 0 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 45px;
            height: 45px;
        }

        .carousel-control-prev {
            left: 15px;
        }

        .carousel-control-next {
            right: 15px;
        }
    }

    @media (max-width: 576px) {
        .products-grid-3col {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .catalog-section {
            padding: 20px 0;
        }

        .pc-media {
            height: 200px;
        }

        .slide-title {
            font-size: 1.8rem;
        }

        .category-label {
            padding: 6px 15px;
            font-size: 0.75rem;
            margin-bottom: 15px;
        }

        .slide-description {
            font-size: 0.9rem;
            padding: 0 15px;
        }

        .shop-category-btn {
            padding: 12px 25px;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .carousel-indicators {
            bottom: 15px;
        }

        .category-product-image {
            max-height: 200px;
        }
    }

    /* Asegurar que las cards tengan la misma altura */
    .products-grid-3col .product-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .products-grid-3col .pc-body {
        flex-grow: 1;
    }

    .products-grid-3col .pc-actions {
        margin-top: auto;
    }
</style>

<!-- Hero de Categoría -->
<div class="meatology-hero-section">
    @php
        $heroName  = $heroCategory->name ?? 'All Products';
        $heroImage = isset($heroCategory?->image) ? Storage::url($heroCategory->image) : asset('images/category-placeholder.jpg');
        $heroCount = isset($heroCategory) ? ($heroCategory->products_count ?? 0) : $products->total();
    @endphp

    <div class="category-hero-slide">
        <div class="slide-background">
            <img src="{{ $heroImage }}" class="slide-bg-image" alt="{{ $heroName }}" loading="lazy">
            <div class="slide-overlay"></div>
        </div>

        <div class="slide-content">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="slide-text">
                            <div class="category-label">
                                {{ $heroCount }} {{ \Illuminate\Support\Str::plural('Product', $heroCount) }} Available
                            </div>
                            <h1 class="slide-title">{{ strtoupper($heroName) }}</h1>
                            <p class="slide-description">
                                Experience the finest quality {{ strtolower($heroName) }} from family-owned farms.
                                Naturally and sustainably raised for exceptional flavor.
                            </p>

                            @if(isset($selectedCategory))
                                <a href="{{ route('shop.index', ['category' => $selectedCategory->id] + request()->only('country','sort')) }}"
                                   class="shop-category-btn">
                                    SHOP {{ strtoupper($heroName) }}
                                </a>
                            @else
                                <a href="#catalog" class="shop-category-btn">BROWSE COLLECTION</a>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="slide-image">
                            <img src="{{ $heroImage }}" alt="{{ $heroName }}" class="category-product-image" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- Sección del Catálogo -->
<div class="catalog-section">
    <div class="container">
        <h1 class="catalog-title">Our Products</h1>

        <!-- Filtro Simple -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('shop.index') }}" class="d-flex gap-3 align-items-center flex-wrap justify-content-center">
                
                <!-- Filtro por Categoría -->
                <div class="filter-group">
                    <label class="filter-label">Category:</label>
                    <select name="category" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}{{ $cat->country ? ' - ' . $cat->country : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtro por País -->
                <div class="filter-group">
                    <label class="filter-label">Country:</label>
                    <select name="country" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ordenamiento -->
                <div class="filter-group">
                    <label class="filter-label">Sort by:</label>
                    <select name="sort" class="filter-select" onchange="this.form.submit()">
                        <option value="">Featured</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                </div>

                <!-- Contador de productos -->
                <div class="filter-group">
                    <span class="filter-label">{{ $products->total() }} products</span>
                </div>
            </form>
        </div>

        <!-- Grid de Productos -->
        <div class="products-grid-3col">
            @forelse ($products as $product)
                <div class="product-card">
                    {{-- MEDIA --}}
                    <div class="pc-media">
                        @php $imgs = $product->images; @endphp
                        @if($imgs->count() > 1)
                            <a href="{{ route('product.show', $product) }}" class="pc-media-link">
                                <div id="productCarousel-{{ $product->id }}" class="carousel slide product-carousel" data-bs-ride="false">
                                    <div class="carousel-inner">
                                        @foreach($imgs as $k => $img)
                                            <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($img->image) }}"
                                                     class="pc-img"
                                                     alt="{{ $product->name }}"
                                                     loading="lazy"
                                                     onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('product.show', $product) }}" class="pc-media-link">
                                <img src="{{ $imgs->first()?->image ? Storage::url($imgs->first()->image) : asset('images/placeholder.jpg') }}"
                                     class="pc-img"
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            </a>
                        @endif

                        {{-- Badge de Descuento --}}
                        @if($product->descuento > 0)
                            <span class="position-absolute top-0 end-0 badge bg-danger m-2 fs-6">
                                -{{ $product->descuento }}% OFF
                            </span>
                        @endif
                    </div>

                    {{-- BODY --}}
                    <div class="pc-body">
                        <div class="pc-category">{{ $product->category->name ?? 'Uncategorized' }}</div>

                        <h3 class="pc-title">
                            <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                        </h3>

                        @php
                            $basePrice = (float)($product->price ?? 0) + (float)($product->interest ?? 0);
                            $discountAmount = ($basePrice * ($product->descuento ?? 0)) / 100;
                            $finalPrice = $basePrice - $discountAmount;
                            $avg = $product->avg_weight;
                            if ($avg && !str_ends_with(strtolower($avg), 'lb') && !str_ends_with(strtolower($avg), 'kg')) {
                                $avg .= ' lb';
                            }
                        @endphp
                        
                        <div class="pc-price-row">
                            @if($product->descuento > 0)
                                <div class="pc-price-original text-muted text-decoration-line-through small">
                                    ${{ number_format($basePrice, 2, '.', ',') }}
                                </div>
                                <div class="pc-price text-danger fw-bold">${{ number_format($finalPrice, 2, '.', ',') }}</div>
                            @else
                                <div class="pc-price">${{ number_format($basePrice, 2, '.', ',') }}</div>
                            @endif
                            <div class="pc-weight">/ {{ $avg ?: 'per lb' }}</div>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="pc-actions">
                        <a href="{{ route('product.show', $product) }}" class="btn-ghost">
                            <i class="fas fa-eye"></i> <span>View Details</span>
                        </a>
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-solid">
                                <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="no-products">
                        <p>No products found with the selected filters.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(isset($products) && $products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap no está cargado. Asegúrate de incluir Bootstrap JS en tu layout.');
        return;
    }

    try {
        const mainCarouselElement = document.getElementById('categoryCarousel');
        if (mainCarouselElement) {
            const mainCarousel = new bootstrap.Carousel(mainCarouselElement, {
                interval: 5000,
                ride: 'carousel',
                wrap: true,
                touch: true,
                pause: 'hover'
            });
            console.log('Carrusel principal inicializado correctamente');
        }

        const productCarousels = document.querySelectorAll('.product-carousel');
        productCarousels.forEach(function(carouselElement) {
            try {
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: false,
                    ride: false,
                    wrap: true,
                    touch: true,
                    pause: 'hover'
                });
                
                carouselElement.addEventListener('mouseenter', function() {
                    carousel.cycle();
                });
                
                carouselElement.addEventListener('mouseleave', function() {
                    carousel.pause();
                });
                
            } catch (error) {
                console.warn('Error inicializando carrusel de producto:', error);
            }
        });

        console.log(`${productCarousels.length} carruseles de productos inicializados`);

    } catch (error) {
        console.error('Error general inicializando carruseles:', error);
    }

    const images = document.querySelectorAll('img');
    images.forEach(function(img) {
        img.addEventListener('error', function() {
            console.warn('Error cargando imagen:', this.src);
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzAxMTkwNCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbiBubyBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg==';
        });
    });
});

function debugCarousel() {
    const carousel = document.getElementById('categoryCarousel');
    if (carousel) {
        const instance = bootstrap.Carousel.getInstance(carousel);
        console.log('Instancia del carrusel:', instance);
        console.log('Elemento del carrusel:', carousel);
        console.log('Items del carrusel:', carousel.querySelectorAll('.carousel-item').length);
    } else {
        console.error('No se encontró el carrusel');
    }
}

window.debugCarousel = debugCarousel;
</script>

@endsection