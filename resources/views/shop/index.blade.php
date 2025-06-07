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
        border-radius: 10px;
        margin-bottom: 20px;
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
        gap: 20px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        justify-items: center;
        flex: 1;
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
        transition: all 0.3s ease;
    }

    .btn-buy:hover {
        background-color: #e69b1f;
        transform: translateY(-2px);
    }

    .quick-view-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(1, 25, 4, 0.85);
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

    .modal-backdrop {
        background-color: rgba(1, 25, 4, 0.8);
    }

    /* Mobile Filter Toggle */
    .mobile-filter-toggle {
        display: none;
        background-color: var(--highlight);
        color: #000;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: bold;
        margin-bottom: 20px;
        width: 100%;
    }

    .mobile-filter-toggle:hover {
        background-color: #e69b1f;
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
    }

    .category-hero-slide {
        position: relative;
        height: 35vh;
        min-height: 300px;
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
        padding: 20px 0;
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
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        line-height: 1.1;
        color: #fff;
    }

    .slide-description {
        font-size: 1rem;
        margin-bottom: 20px;
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
    }

    .slide-image {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .category-product-image {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .category-product-image:hover {
        transform: scale(1.05);
    }

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
    }

    .carousel-indicators button.active {
        background: #c41e3a;
        border-color: #fff;
        transform: scale(1.2);
    }

    .carousel-item {
        height: 49vh;
        position: relative;
    }

    /* RESPONSIVE STYLES */
    
    /* Large Tablets and Small Desktops */
    @media (max-width: 1200px) {
        .slide-title {
            font-size: 2.2rem;
        }
        
        .catalog-title {
            font-size: 2.2rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
        }
    }

    /* Tablets */
    @media (max-width: 992px) {
        .catalog-container {
            flex-direction: column;
        }
        
        .sidebar {
            border-right: none;
            border-bottom: 1px solid #1c3825;
            margin-bottom: 30px;
        }
        
        .mobile-filter-toggle {
            display: block;
        }
        
        .sidebar.collapsed {
            display: none;
        }
        
        .category-hero-slide {
            height: 30vh;
            min-height: 280px;
        }
        
        .slide-background {
            width: 100%;
            opacity: 0.4;
        }
        
        .slide-content {
            text-align: center;
        }
        
        .slide-text {
            padding-right: 0;
            margin-bottom: 20px;
        }
        
        .slide-title {
            font-size: 2rem;
            letter-spacing: 1px;
        }
        
        .slide-description {
            margin: 0 auto 20px;
        }
        
        .catalog-title {
            font-size: 2rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
    }

    /* Mobile Landscape and Small Tablets */
    @media (max-width: 768px) {
         .carousel-item {
            height: 30vh;
            position: relative;
        }
        .category-hero-slide {
            height: 28vh;
            min-height: 260px;
        }
        
        .slide-title {
            font-size: 1.8rem;
            letter-spacing: 1px;
        }
        
        .slide-description {
            font-size: 0.9rem;
            padding: 0 20px;
        }
        
        .shop-category-btn {
            padding: 12px 25px;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        
        .category-product-image {
            max-height: 180px;
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
        
        .catalog-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .sidebar {
            padding: 15px;
        }
        
        .sidebar h5 {
            font-size: 0.9rem;
            margin-top: 15px;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        .product-card {
            max-width: none;
        }
        
        .product-card img {
            height: 200px;
        }
        
        .product-info {
            padding: 12px;
        }
        
        .product-info h5 {
            font-size: 1rem;
            margin-bottom: 8px;
        }
        
        .product-price {
            font-size: 1.1rem;
        }
        
        /* Modal responsive */
        .modal-xl {
            max-width: 95%;
            margin: 1rem auto;
        }
        
        .modal-body {
            padding: 15px;
        }
        
        .modal-body .row {
            --bs-gutter-x: 0;
        }
        
        .modal-body .col-md-6:first-child {
            margin-bottom: 20px;
        }
        
        #quickViewMainImage {
            height: 250px !important;
        }
        
        .quick-view-btn {
            display: inline-block !important;
            position: static;
            transform: none;
            margin-top: 10px;
            width: 100%;
        }
    }

    /* Mobile Portrait */
    @media (max-width: 576px) {
         .carousel-item {
            height: 30vh;
            position: relative;
        }
        .slide-title {
            font-size: 1.6rem;
        }
        
        .category-label {
            padding: 6px 15px;
            font-size: 0.75rem;
            margin-bottom: 15px;
        }
        
        .carousel-indicators {
            bottom: 15px;
        }
        
        .category-hero-slide {
            min-height: 240px;
            height: 25vh;
        }
        
        .shop-category-btn {
            padding: 10px 20px;
            font-size: 0.75rem;
        }
        
        .catalog-title {
            font-size: 1.6rem;
            margin-bottom: 15px;
        }
        
        .container-fluid {
            padding: 20px 15px;
        }
        
        .sidebar {
            padding: 12px;
            border-radius: 8px;
        }
        
        .mobile-filter-toggle {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 0.8rem;
        }
        
        .product-card img {
            height: 180px;
        }
        
        .product-info {
            padding: 10px;
        }
        
        .product-info h5 {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }
        
        .product-price {
            font-size: 1rem;
            margin-top: 8px;
        }
        
        .btn-buy {
            padding: 8px 12px;
            font-size: 0.85rem;
        }
        
        /* Modal extra responsive */
        .modal-xl {
            max-width: 98%;
            margin: 0.5rem auto;
        }
        
        .modal-header {
            padding: 10px 15px;
        }
        
        .modal-title {
            font-size: 1.1rem;
        }
        
        .modal-body {
            padding: 10px;
        }
        
        #quickViewMainImage {
            height: 200px !important;
        }
        
        .modal-body .col-md-6 {
            padding: 0;
        }
        
        .modal-body .row.mb-4 .col-6,
        .modal-body .row.mb-4 .col-12 {
            margin-bottom: 10px;
        }
        
        .modal-body .p-3 {
            padding: 10px !important;
        }
        
        .btn-buy.w-100.py-3 {
            padding: 12px !important;
            font-size: 0.95rem !important;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 480px) {
         .carousel-item {
            height: 30vh;
            position: relative;
        }
        .slide-title {
            font-size: 1.4rem;
        }
        
        .catalog-title {
            font-size: 1.4rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 0.6rem;
        }
        
        .product-card img {
            height: 160px;
        }
        
        .product-info h5 {
            font-size: 0.9rem;
        }
        
        .product-price {
            font-size: 0.95rem;
        }
        
        .btn-buy {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    }

    /* Landscape mode adjustments for mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        .carousel-item {
            height: 30vh;
            position: relative;
        }
        .category-hero-slide {
            height: 50vh;
            min-height: 200px;
        }
        
        .slide-title {
            font-size: 1.5rem;
        }
        
        .slide-description {
            font-size: 0.85rem;
        }
        
        .shop-category-btn {
            padding: 8px 16px;
            font-size: 0.7rem;
        }
        
        .category-product-image {
            max-height: 120px;
        }
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

<div class="container-fluid py-5">
    <h1 class="text-center catalog-title mb-4">Meatology Catalog 🥩</h1>

    <!-- Mobile Filter Toggle -->
    <button class="mobile-filter-toggle" onclick="toggleFilters()">
        <i class="fas fa-filter me-2"></i>Show Filters
    </button>

    <div class="catalog-container">
        <!-- Sidebar -->
        <div class="sidebar col-lg-3" id="filterSidebar">
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
        <div class="product-grid-container col-lg-9">
            <div class="product-grid">
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
                                data-price="{{ number_format(($product->price ?? 0) + ($product->interest ?? 0), 0) }}"
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
                            @php
                                $totalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
                            @endphp
                            <div class="product-price">${{ number_format($totalPrice, 0, ',', '.') }}</div>

                            <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-buy">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-light text-center">No products found with the selected filters.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-5 text-center">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

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
                    
                    <!-- Columna de información -->
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

<script>
// Mobile filter toggle
function toggleFilters() {
    const sidebar = document.getElementById('filterSidebar');
    const toggleButton = document.querySelector('.mobile-filter-toggle');
    
    sidebar.classList.toggle('collapsed');
    
    if (sidebar.classList.contains('collapsed')) {
        toggleButton.innerHTML = '<i class="fas fa-filter me-2"></i>Show Filters';
    } else {
        toggleButton.innerHTML = '<i class="fas fa-times me-2"></i>Hide Filters';
    }
}

// Auto-hide filters on larger screens
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('filterSidebar');
    const toggleButton = document.querySelector('.mobile-filter-toggle');
    
    if (window.innerWidth >= 992) {
        sidebar.classList.remove('collapsed');
        toggleButton.innerHTML = '<i class="fas fa-filter me-2"></i>Show Filters';
    }
});
</script>

@endsection