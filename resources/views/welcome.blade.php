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

@endsection
