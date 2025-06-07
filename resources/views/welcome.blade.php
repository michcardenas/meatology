@extends('layouts.app')

@section('content')

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
                                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Shop Premium Cuts</a>
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
                                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Shop Quality Cuts</a>
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
                                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Shop Sustainable Beef</a>
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
                                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Start Shopping Now</a>
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
    <div class="row g-4">
    @foreach($featuredProducts->take(6) as $index => $product)
    <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #fdfdfd;">
            
            <!-- Imagen del producto -->
            <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}"
                 class="card-img-top" alt="{{ $product->name }}"
                 style="height: 320px; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

            <!-- Contenido -->
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-dark mb-2" style="font-family: 'Georgia', serif;">
                    {{ $product->name }}
                </h4>

                <p class="card-text text-muted">{{ Str::limit($product->description, 180) }}</p>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <span class="h5 text-success fw-bold">${{ number_format($product->price, 2) }}</span>
                        <small class="text-muted">/ per kg</small>

                        @if($product->stock <= 0)
                            <span class="badge bg-danger ms-2">Out of Stock</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark ms-2">Limited Stock</span>
                        @else
                            <span class="badge bg-success ms-2">Available</span>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-dark btn-sm rounded-pill">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button class="btn btn-outline-success btn-sm rounded-pill add-to-cart"
                                data-product-id="{{ $product->id }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

    </div>
</section>

<!-- Call to Action: View All Products -->
<!-- Call to Action: View All Products -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #011904 40%, #a6ff8f 100%);">
    <div class="container">
        <h2 class="mb-4 fw-bold">Want to explore our full selection?</h2>
        <p class="lead text-light">Discover all our premium cuts and find the perfect choice for your next culinary adventure.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-lg btn-light text-dark fw-semibold mt-3 shadow-sm">
            <i class="fas fa-store me-2"></i> View All Products
        </a>
    </div>
</section>


<!-- Category Showcase (with background that matches #011904) -->
<section class="py-5" style="background: linear-gradient(135deg, #011904 50%, #e4f6e9 100%);">
    <div class="container">
        <div class="row text-center mb-5 text-white">
            <div class="col">
                <span class="section-badge bg-light text-dark px-3 py-1 rounded-pill">🧾 Categories</span>
                <h2 class="section-title text-white mt-3">Browse by Category</h2>
                <p class="section-description text-light">Select the perfect cut based on your preference or culinary needs.</p>
                <div class="section-divider mx-auto bg-light" style="height: 3px; width: 80px;"></div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($categories as $index => $category)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow border-0">
                    <img src="{{ $category->image ? Storage::url($category->image) : asset('images/category-placeholder.jpg') }}"
                         alt="{{ $category->name }}"
                         class="card-img-top" style="height: 220px; object-fit: cover;">

                    <div class="card-body bg-white rounded-bottom">
                        <h5 class="card-title fw-bold text-dark">{{ $category->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-dark mt-2">
                            Explore Category
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
