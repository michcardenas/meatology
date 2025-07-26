@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #011904;
        color: #e5e5e5;
        font-family: 'Inter', Arial, sans-serif;
    }

    .catalog-section {
        min-height: 100vh;
        padding: 40px 0;
    }

    .catalog-title {
        color: #acafab;
        font-size: 2.2rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 40px;
    }

    /* Filtro Simple */
    .filter-bar {
        background: rgba(17, 39, 23, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(172, 175, 171, 0.2);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 40px;
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-label {
        color: #acafab;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .filter-select {
        background: rgba(1, 25, 4, 0.8);
        border: 1px solid rgba(172, 175, 171, 0.3);
        border-radius: 8px;
        color: #e5e5e5;
        padding: 8px 15px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #acafab;
        box-shadow: 0 0 0 2px rgba(172, 175, 171, 0.1);
    }

    /* Grid de Productos */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .product-card {
        background: rgba(17, 39, 23, 0.4);
        border: 1px solid rgba(172, 175, 171, 0.15);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(172, 175, 171, 0.4);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .product-image {
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        color: #acafab;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .product-category {
        color: #888;
        font-size: 0.85rem;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-price {
        color: #f7a831;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .add-to-cart-btn {
        width: 100%;
        background: transparent;
        border: 2px solid #acafab;
        color: #acafab;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background: #acafab;
        color: #011904;
        transform: translateY(-2px);
    }

    /* Responsive */
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

        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-image img {
            height: 220px;
        }

        .product-info {
            padding: 15px;
        }

        /* Carrusel responsive */
        .carousel-item {
            height: 45vh;
            min-height: 350px;
        }

        .slide-background {
            width: 100%;
            opacity: 0.4;
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

    @media (max-width: 480px) {
        .catalog-section {
            padding: 20px 0;
        }

        .products-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .product-image img {
            height: 200px;
        }

        /* Carrusel móvil */
        .carousel-item {
            height: 40vh;
            min-height: 300px;
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

    /* No products message */
    .no-products {
        text-align: center;
        color: #888;
        font-size: 1.1rem;
        margin-top: 60px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }

    /* Carrusel Styles */
    .meatology-carousel-section {
        background: linear-gradient(135deg, #2d5016 0%, #3d6b1f 100%);
        margin: 0;
        padding: 0;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-bottom: 0;
    }

    .carousel-item {
        height: 50vh;
        position: relative;
        min-height: 400px;
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
        opacity: 0.3;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            rgba(45, 80, 22, 0.9) 0%, 
            rgba(45, 80, 22, 0.7) 50%, 
            rgba(45, 80, 22, 0.3) 100%);
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
        color: white;
        padding-right: 40px;
    }

    .category-label {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 8px 20px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        color: #fff;
    }

    .slide-title {
        font-size: 2.8rem;
        font-weight: 900;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        line-height: 1.1;
        color: #fff;
    }

    .slide-description {
        font-size: 1.1rem;
        margin-bottom: 25px;
        opacity: 0.9;
        line-height: 1.5;
        max-width: 450px;
        color: #f0f0f0;
    }

    .shop-category-btn {
        display: inline-block;
        background: #c41e3a;
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(196, 30, 58, 0.3);
    }

    .shop-category-btn:hover {
        background: #e74c3c;
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(196, 30, 58, 0.4);
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
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
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
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.2);
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
        background: rgba(255, 255, 255, 0.2);
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

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.6);
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .carousel-indicators button.active {
        background: #c41e3a;
        border-color: #fff;
        transform: scale(1.2);
    }
</style>
<div class="meatology-carousel-section">
    <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($categories as $index => $category)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="category-hero-slide">
                        <div class="slide-background">
                            <img src="{{ $category->image ? Storage::url($category->image) : asset('images/category-placeholder.jpg') }}"
                                 class="slide-bg-image" alt="{{ $category->name }}">
                            <div class="slide-overlay"></div>
                        </div>
                        <div class="slide-content">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="slide-text">
                                            <div class="category-label">{{ $category->products_count }} Products Available</div>
                                            <h1 class="slide-title">{{ strtoupper($category->name) }}</h1>
                                            <p class="slide-description">
                                                Experience the finest quality {{ strtolower($category->name) }} from family-owned farms. 
                                                Naturally and sustainably raised for exceptional flavor.
                                            </p>
                                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="shop-category-btn">
                                                SHOP {{ strtoupper($category->name) }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none d-lg-block">
                                        <div class="slide-image">
                                            <img src="{{ $category->image ? Storage::url($category->image) : asset('images/category-placeholder.jpg') }}"
                                                 alt="{{ $category->name }}" class="category-product-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Indicadores -->
        <div class="carousel-indicators">
            @foreach($categories as $index => $category)
                <button type="button" data-bs-target="#categoryCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $index == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
    </div>
</div>
<div class="catalog-section">
    <div class="container">
        <h1 class="catalog-title">Our Products</h1>

        <!-- Filtro Simple -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('shop.index') }}" class="d-flex gap-3 align-items-center flex-wrap justify-content-center">
                <div class="filter-group">
                    <label class="filter-label">Category:</label>
                    <select name="category" class="filter-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name . ' - ' . $cat->country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Sort by:</label>
                    <select name="sort" class="filter-select" onchange="this.form.submit()">
                        <option value="">Featured</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                </div>

                <div class="filter-group">
                    <span class="filter-label">{{ $products->total() }} products</span>
                </div>
            </form>
        </div>

        <!-- Grid de Productos -->
        <div class="products-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}" 
                             alt="{{ $product->name }}"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjI1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMmQ1MDE2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPnt7ICRwcm9kdWN0LT5uYW1lIH19PC90ZXh0Pjwvc3ZnPic;">
                    </div>
                    
                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        
                        @php
                            $totalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
                        @endphp
                        <div class="product-price">${{ number_format($totalPrice, 0) }}</div>
                        
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
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

        <!-- Paginación -->
        @if(isset($products) && $products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // Inicializar carrusel cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si Bootstrap está cargado
        if (typeof bootstrap !== 'undefined') {
            // Inicializar carrusel manualmente
            const carouselElement = document.getElementById('categoryCarousel');
            if (carouselElement) {
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000,
                    ride: 'carousel',
                    wrap: true,
                    touch: true
                });
                
                console.log('Carrusel inicializado correctamente');
            }
        } else {
            console.warn('Bootstrap no está cargado. Verifica que Bootstrap JS esté incluido en tu layout.');
        }

        // Manejo de errores de imágenes
        const images = document.querySelectorAll('.slide-bg-image, .category-product-image, .product-image img');
        images.forEach(function(img) {
            img.addEventListener('error', function() {
                console.log('Error cargando imagen:', this.src);
                // Usar un placeholder SVG en caso de error
                this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMmQ1MDE2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbiBubyBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg==';
            });
        });

        // Debug: Mostrar información del carrusel
        setTimeout(function() {
            const carouselInner = document.querySelector('.carousel-inner');
            const carouselItems = document.querySelectorAll('.carousel-item');
            
            if (carouselInner) {
                console.log('Carrusel encontrado con', carouselItems.length, 'items');
            } else {
                console.error('No se encontró el carrusel en el DOM');
            }
        }, 1000);
    });

    // Función para forzar la reinicialización del carrusel si es necesario
    function reinitializeCarousel() {
        const carouselElement = document.getElementById('categoryCarousel');
        if (carouselElement && typeof bootstrap !== 'undefined') {
            // Destruir instancia existente si la hay
            const existingCarousel = bootstrap.Carousel.getInstance(carouselElement);
            if (existingCarousel) {
                existingCarousel.dispose();
            }
            
            // Crear nueva instancia
            const newCarousel = new bootstrap.Carousel(carouselElement, {
                interval: 5000,
                ride: 'carousel',
                wrap: true,
                touch: true
            });
            
            console.log('Carrusel reinicializado');
            return newCarousel;
        }
        return null;
    }

    // Llamar esta función desde la consola si el carrusel no funciona
    window.reinitializeCarousel = reinitializeCarousel;
</script>

@endsection