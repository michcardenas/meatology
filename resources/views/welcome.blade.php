@extends('layouts.app')

@section('content')

<style>
 
        .hero-video-section {
            height: 60vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        /* Video de fondo */
        .hero-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            z-index: 0;
            object-fit: cover;
        }
        
        /* Overlay oscuro sobre el video */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        /* Contenido sobre el video */
        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
            animation: fadeInUp 1.5s ease-out;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 30px;
            color: #f4f1e7;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
        }
        
        .hero-content .lead {
            font-size: 1.4rem;
            color: #e0d9c0;
            font-weight: 300;
            line-height: 1.6;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            margin-bottom: 40px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #e0d9c0, #f4f1e7);
            color: #011904;
            border: none;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(224, 217, 192, 0.4);
            color: #011904;
            text-decoration: none;
        }
        
        /* Controles de video personalizados */
        .video-controls {
            position: absolute;
            bottom: 30px;
            right: 30px;
            z-index: 3;
        }
        
        .video-control-btn {
            background: rgba(1, 25, 4, 0.8);
            color: #e0d9c0;
            border: 2px solid rgba(224, 217, 192, 0.3);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 10px;
        }
        
        .video-control-btn:hover {
            background: rgba(224, 217, 192, 0.2);
            border-color: #e0d9c0;
            transform: scale(1.1);
        }
        .position-relative {
    overflow: hidden;
}
.product-card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-card-actions {
    margin-top: auto;
    padding-top: 1rem;
}
/* Efecto de zoom en las imágenes */
.card-img-top {
    transition: transform 0.4s ease-in-out;
}

.card-img-top:hover {
    transform: scale(1.08);
}
        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content .lead {
                font-size: 1.2rem;
            }
            
            .video-controls {
                bottom: 20px;
                right: 20px;
            }
        }
        
    </style>

<!-- Hero Section -->
<section id="inicio" class="hero-video-section">
    <!-- Video de fondo -->
    <video class="hero-video" autoplay muted loop playsinline>
        <source src="{{ asset('videos/carne.mp4') }}" type="video/mp4">
        <!-- Imagen de fallback si el video no carga -->
        Tu navegador no soporta videos. 
    </video>
    
    <!-- Overlay -->
    <div class="hero-overlay"></div>
    
    <!-- Contenido principal -->
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
</section>
<!-- Sección de Productos Destacados con Fondo Verde Oscuro -->

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
                        {{-- MEDIA CON CARRUSEL --}}
                        @php $imgs = $product->images; @endphp
                        @if($imgs->count() > 1)
                            <a href="{{ route('product.show', $product) }}" class="text-decoration-none">
                                <div id="featuredCarousel-{{ $product->id }}" class="carousel slide featured-product-carousel" data-bs-ride="false">
                                    <div class="carousel-inner">
                                        @foreach($imgs as $k => $img)
                                            <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($img->image) }}"
                                                     class="card-img-top"
                                                     alt="{{ $product->name }}"
                                                     style="height: 320px; object-fit: fill; box-shadow: 0 4px 15px rgba(0,0,0,0.08);"
                                                     loading="lazy"
                                                     onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Controles del carrusel (solo visibles en hover) -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel-{{ $product->id }}" data-bs-slide="prev" style="opacity: 0; transition: opacity 0.3s;">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel-{{ $product->id }}" data-bs-slide="next" style="opacity: 0; transition: opacity 0.3s;">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                    
                                    <!-- Indicadores del carrusel -->
                                    <div class="carousel-indicators" style="opacity: 0; transition: opacity 0.3s;">
                                        @foreach($imgs as $k => $img)
                                            <button type="button" data-bs-target="#featuredCarousel-{{ $product->id }}" data-bs-slide-to="{{ $k }}" {{ $k === 0 ? 'class=active aria-current=true' : '' }} aria-label="Slide {{ $k + 1 }}"></button>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('product.show', $product) }}" class="text-decoration-none">
                                <img src="{{ $imgs->first()?->image ? Storage::url($imgs->first()->image) : asset('images/placeholder.jpg') }}"
                                     class="card-img-top" alt="{{ $product->name }}"
                                     style="height: 320px; object-fit: fill; box-shadow: 0 4px 15px rgba(0,0,0,0.08);"
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

                    <!-- Contenido -->
                    <div class="card-body p-4" style="
    display: flex;
    flex-direction: column;
    justify-content: space-between;
">
                        <h4 class="card-title fw-bold text-dark mb-2" style="font-family: 'Georgia', serif;">
                            {{ $product->name }}
                        </h4>

                        <!-- Descripción sin etiquetas HTML -->
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($product->description), 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                @php
                                    $basePrice = ($product->price ?? 0) + ($product->interest ?? 0);
                                    $discountAmount = ($basePrice * ($product->descuento ?? 0)) / 100;
                                    $finalPrice = $basePrice - $discountAmount;
                                @endphp
                                
                                {{-- Mostrar precio con o sin descuento --}}
                                @if($product->descuento > 0)
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
                                @if(!empty($product->avg_weight))
                                    <small class="text-muted">/ {{ $product->avg_weight }}</small>
                                @endif

                                @if($product->stock <= 0)
                                    <span class="badge bg-danger ms-2">Out of Stock</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge bg-warning text-dark ms-2">Limited Stock</span>
                                @else
                                    <span class="badge bg-success ms-2">Available</span>
                                @endif
                            </div>
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
                         class="card-img-top" style="height: 220px; object-fit: contain;">

                    <div class="card-body bg-white rounded-bottom">
                        <h5 class="card-title fw-bold text-dark">{{ $category->name }}</h5>
@php
    $desc = $product->description ?? '';

    // 1) Decodifica entidades HTML repetidamente (por si viene &amp;nbsp;)
    for ($i = 0; $i < 3; $i++) {
        $decoded = html_entity_decode($desc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($decoded === $desc) break;
        $desc = $decoded;
    }

    // 2) Quita etiquetas HTML si quedaran
    $desc = strip_tags($desc);

    // 3) Normaliza NBSP: entidad, numérica y el carácter real U+00A0
    $desc = preg_replace('/(&nbsp;|&#160;)/i', ' ', $desc);      // entidades -> espacio
    $desc = str_replace("\xC2\xA0", ' ', $desc);                 // byte UTF-8 NBSP -> espacio

    // 4) Colapsa espacios múltiples y recorta
    $desc = preg_replace('/\s+/u', ' ', trim($desc));
@endphp

<p class="card-text text-muted">
    {{ \Illuminate\Support\Str::limit($desc, 120) }}
</p>
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
<style>
/* Estilos para el carrusel de productos destacados */
.featured-product-carousel {
    cursor: pointer;
}

.featured-product-carousel:hover .carousel-control-prev,
.featured-product-carousel:hover .carousel-control-next,
.featured-product-carousel:hover .carousel-indicators {
    opacity: 0.8 !important;
}

.featured-product-carousel .carousel-control-prev,
.featured-product-carousel .carousel-control-next {
    width: 5%;
    background-color: rgba(0, 0, 0, 0.3);
}

.featured-product-carousel .carousel-control-prev:hover,
.featured-product-carousel .carousel-control-next:hover {
    opacity: 1 !important;
    background-color: rgba(0, 0, 0, 0.5);
}

.featured-product-carousel .carousel-indicators {
    bottom: 10px;
}

.featured-product-carousel .carousel-indicators [data-bs-target] {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 3px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que Bootstrap esté disponible
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap no está cargado. Asegúrate de incluir Bootstrap JS en tu layout.');
        return;
    }

    try {
        // Inicializar carruseles de productos destacados
        const featuredCarousels = document.querySelectorAll('.featured-product-carousel');
        featuredCarousels.forEach(function(carouselElement) {
            try {
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: false, // No auto-slide
                    ride: false,
                    wrap: true,
                    touch: true,
                    pause: 'hover'
                });
                
                // Prevenir navegación cuando se hace clic en controles
                const controls = carouselElement.querySelectorAll('.carousel-control-prev, .carousel-control-next, .carousel-indicators button');
                controls.forEach(function(control) {
                    control.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
                
                // Activar el carrusel en hover
                carouselElement.addEventListener('mouseenter', function() {
                    const interval = setInterval(() => {
                        carousel.next();
                    }, 2000);
                    
                    carouselElement.addEventListener('mouseleave', function() {
                        clearInterval(interval);
                    }, { once: true });
                });
                
            } catch (error) {
                console.warn('Error inicializando carrusel de producto destacado:', error);
            }
        });

        console.log(`${featuredCarousels.length} carruseles de productos destacados inicializados`);

    } catch (error) {
        console.error('Error general inicializando carruseles:', error);
    }

    // Manejo de errores de imágenes
    const images = document.querySelectorAll('img');
    images.forEach(function(img) {
        img.addEventListener('error', function() {
            console.warn('Error cargando imagen:', this.src);
            // Placeholder SVG
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMmQ1MDE2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbiBubyBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg==';
        });
    });
});
</script>
@endsection
