<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meatology</title>

    {{-- Favicon y meta para iconos --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- CSS y JS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
/* Navigation Responsive Styles */
nav {
    background-color: #013105;
    padding: 12px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    position: relative;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 1000;
}

.logo img {
    height: 75px;
}

.logo span {
    font-size: 1.2rem;
    letter-spacing: 2px;
    font-weight: 500;
    color: #e0d9c0;
}

/* Desktop Navigation */
.nav-links {
    display: flex;
    align-items: center;
    gap: 30px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.nav-links a {
    color: #e0d9c0;
    text-decoration: none;
    font-size: 0.95rem;
    position: relative;
    transition: color 0.3s ease;
}

.nav-links a:hover,
.nav-links a.active {
    color: #f4f1e7;
}

.nav-icons {
    display: flex;
    align-items: center;
    gap: 18px;
}

.nav-icons i {
    color: #e0d9c0;
    font-size: 1.1rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.nav-icons i:hover {
    color: #f4f1e7;
}

.nav-icons a {
    color: #e0d9c0;
    text-decoration: none;
    transition: color 0.3s ease;
}

.nav-icons a:hover {
    color: #f4f1e7;
}

/* Mobile Menu Toggle */
.mobile-menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #e0d9c0;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 5px;
    z-index: 1001;
}

.mobile-menu-toggle:hover {
    color: #f4f1e7;
}

/* Mobile Navigation */
.mobile-nav {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(1, 25, 4, 0.98);
    backdrop-filter: blur(10px);
    z-index: 999;
    padding-top: 80px;
}

.mobile-nav.active {
    display: block;
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mobile-nav-links {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    margin-top: 50px;
}

.mobile-nav-links a {
    color: #e0d9c0;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    padding: 10px 20px;
    border-radius: 8px;
}

.mobile-nav-links a:hover,
.mobile-nav-links a.active {
    color: #f4f1e7;
    background: rgba(224, 217, 192, 0.1);
    transform: translateY(-2px);
}

.mobile-nav-icons {
    display: flex;
    justify-content: center;
    gap: 25px;
    margin-top: 50px;
    padding: 0 20px;
}

.mobile-nav-icons a,
.mobile-nav-icons .dropdown {
    color: #e0d9c0;
    font-size: 1.3rem;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 15px;
    border-radius: 50%;
    background: rgba(224, 217, 192, 0.1);
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-nav-icons a:hover,
.mobile-nav-icons .dropdown:hover {
    color: #f4f1e7;
    background: rgba(224, 217, 192, 0.2);
    transform: scale(1.1);
}

/* Dropdown Styles */
.dropdown-toggle {
    color: inherit;
    text-decoration: none;
    position: relative;
}

.dropdown-toggle::after {
    display: none;
}

.dropdown-menu {
    background: white;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
    min-width: 180px;
    padding: 10px 0;
    margin-top: 8px;
}

.dropdown-item {
    padding: 8px 20px;
    font-size: 0.9rem;
    color: #333;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: #f8f9fa;
    color: #011904;
    transform: translateX(5px);
}

.dropdown-divider {
    margin: 8px 0;
    border-color: rgba(0,0,0,.1);
}

/* Footer Styles */
footer {
    background: linear-gradient(135deg, #011904 0%, #022a07 100%) !important;
    border-top: 3px solid rgb(7, 52, 13);
}

.footer-logo img {
    transition: transform 0.3s ease;
}

.footer-logo:hover img {
    transform: scale(1.05);
}

.social-links {
    display: flex;
    align-items: center;
}

.social-link {
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.social-link:hover {
    color: #fff;
    background: rgba(64, 120, 79, 0.8);
    transform: translateY(-2px);
}

.footer-links {
    margin: 0;
}

.footer-links li {
    margin-bottom: 8px;
}

.footer-link {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    position: relative;
}

.footer-link:hover {
    color: #fff;
    padding-left: 5px;
}

.footer-link::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 2px;
    background: #c41e3a;
    transition: width 0.3s ease;
}

.footer-link:hover::before {
    width: 6px;
}

.newsletter-form {
    position: relative;
}

.newsletter-input {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px 0 0 25px;
    color: white;
    padding: 12px 20px;
    font-size: 0.9rem;
}

.newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: none;
    color: white;
}

.newsletter-btn {
    background: #c41e3a;
    border: 2px solid #c41e3a;
    border-radius: 0 25px 25px 0;
    color: white;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.newsletter-btn:hover {
    background: #e74c3c;
    border-color: #e74c3c;
    transform: translateY(-1px);
}

.contact-info .footer-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.contact-info .footer-link:hover {
    color: #c41e3a;
    padding-left: 0;
}

.certification-badge {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 5px 12px;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.9);
    display: inline-block;
    transition: all 0.3s ease;
}

.certification-badge:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-1px);
}

/* Responsive Media Queries */
@media (max-width: 992px) {
    nav {
        padding: 12px 15px;
    }
    
    .nav-links {
        gap: 20px;
    }
    
    .nav-icons {
        gap: 15px;
    }
}

@media (max-width: 768px) {
    .nav-links {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: block;
    }
    
    .nav-icons {
        gap: 12px;
    }
    
    .nav-icons a {
        font-size: 1rem;
    }
    
    .logo img {
        height: 35px;
    }
    
    /* Footer responsive */
    .social-links {
        justify-content: center;
        margin-top: 20px;
    }
    
    .footer-certifications {
        text-align: center !important;
        margin-top: 20px;
    }
    
    .certification-badge {
        display: block;
        margin: 5px 0;
    }
    
    .newsletter-input,
    .newsletter-btn {
        border-radius: 25px;
        margin-bottom: 10px;
    }
    
    .input-group {
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    nav {
        padding: 8px 15px;
    }
    
    .logo img {
        height: 30px;
    }
    
    .nav-icons {
        gap: 8px;
    }
    
    .nav-icons a {
        font-size: 0.9rem;
    }
    
    /* Footer responsive */
    footer {
        padding-top: 3rem !important;
    }
    
    .footer-logo {
        text-align: center;
    }
    
    .col-lg-2 {
        margin-bottom: 2rem;
    }
}

@media (max-width: 480px) {
    .mobile-nav-links a {
        font-size: 1.1rem;
    }
    
    .mobile-nav-icons a,
    .mobile-nav-icons .dropdown {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
}
/* ===== SUBMENU STYLES - AGREGADO ===== */
.nav-item {
    position: relative;
    display: inline-block;
}

.nav-item > a {
    color: #e0d9c0;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.nav-item:hover > a {
    color: #f4f1e7;
}

/* Primer nivel del submenu (países) */
.submenu {
    position: absolute;
    top: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%);
    background: #013105;
    border: 1px solid rgba(224, 217, 192, 0.3);
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    min-width: 220px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(-50%) translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
    padding: 8px 0;
}

.nav-item:hover .submenu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

/* Items de países */
.country-item {
    position: relative;
}

.country-item > a {
    display: block;
    padding: 12px 20px;
    color: #e0d9c0;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    font-weight: 500;
    font-size: 14px;
}

.country-item:hover > a {
    background: rgba(224, 217, 192, 0.1);
    color: #f4f1e7;
    border-left-color: #c41e3a;
}

/* Flecha indicadora */
.country-item > a::after {
    content: '▶';
    float: right;
    font-size: 10px;
    color: rgba(224, 217, 192, 0.6);
    transition: color 0.3s ease;
}

.country-item:hover > a::after {
    color: #f4f1e7;
}

/* Segundo nivel del submenu (categorías) */
.categories-submenu {
    position: absolute;
    top: 0;
    left: calc(100% + 8px);
    background: #013105;
    border: 1px solid rgba(224, 217, 192, 0.3);
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    min-width: 250px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
    padding: 15px 0;
}

.country-item:hover .categories-submenu {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

/* Header del país en el submenu de categorías */
.categories-header {
    padding: 0 20px 12px;
    border-bottom: 2px solid #c41e3a;
    margin-bottom: 12px;
}

.categories-header h4 {
    margin: 0;
    color: #c41e3a;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Items de categorías */
.category-item {
    padding: 1px 0;
}

.category-item a {
    display: block;
    padding: 10px 20px;
    color: rgba(224, 217, 192, 0.8);
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.category-item a:hover {
    background: rgba(224, 217, 192, 0.1);
    color: #f4f1e7;
    border-left-color: #c41e3a;
    padding-left: 25px;
}

/* Mobile submenu adaptado a tu estilo */
.mobile-submenu {
    display: none;
    background: rgba(224, 217, 192, 0.1);
    padding: 15px 20px;
    margin-top: 10px;
    border-radius: 8px;
    margin-left: 10px;
}

.mobile-submenu.active {
    display: block;
}

.mobile-nav .categories-submenu {
    display: none;
    margin-left: 20px;
    margin-top: 10px;
    background: rgba(224, 217, 192, 0.05);
    border-radius: 5px;
    padding: 10px;
}

/* Responsive para el submenu */
@media (max-width: 768px) {
    .submenu {
        min-width: 250px;
        left: 0;
        transform: translateX(0);
    }
    
    .nav-item:hover .submenu {
        transform: translateX(0) translateY(0);
    }
}
/* ===== FIN SUBMENU STYLES ===== */
</style>

    @vite(['resources/js/app.js'])
</head>
<body>
    <nav>
        <div class="navbar-container">
          <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Meatology Logo">
            </a>
        </div>

            <!-- Desktop Navigation -->
            <div class="nav-links">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

  {{-- NAV ITEM CON SUBMENU --}}
  <div class="nav-item">
    <a href="#" class="has-submenu">
      Products <i class="fas fa-chevron-down" style="font-size: .75rem;"></i>
    </a>

   <div class="submenu">
  @forelse(($categories ?? collect())->unique(fn($c) => mb_strtolower(trim($c->name))) as $category)
    <div class="category-item">
      <a href="{{ route('shop.index', ['category' => $category->id]) }}">
        {{ $category->name }}
      </a>
    </div>
  @empty
    <div class="category-item">
      <a href="{{ route('shop.index') }}">All products</a>
    </div>
  @endforelse
</div>

  </div>

  <a href="{{ route('about') }}">About Us</a>
  <a href="{{ route('login') }}">Insiders</a>
  <a href="{{ route('recipes') }}">Recipes</a>
  <a href="{{ route('partner.chefs') }}" class="{{ request()->routeIs('partner.chefs') ? 'active' : '' }}">Partner Chefs</a>
</div>


            <!-- Desktop Icons -->
            <div class="nav-icons">
                @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" title="Mi cuenta">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <ul style="background: #013105;" class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-user me-2"></i>My Account
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-2"></i>My Cart
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Log Out
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Formulario oculto para logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" title="Iniciar sesión">
                    <i class="fas fa-user-circle"></i>
                </a>
                @endauth
                
                <a class="nav-link" href="{{ route('cart.index') }}">
                    🛒 <span class="badge bg-secondary">{{ Cart::count() }}</span>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars" id="menuIcon"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" id="mobileNav">
            <div class="mobile-nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}">Products</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('partner.chefs') }}" class="{{ request()->routeIs('partner.chefs') ? 'active' : '' }}">Partner Chefs</a>
            </div>

            <div class="mobile-nav-icons">
                @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" title="Mi cuenta">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-user me-2"></i>Mi Cuenta
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-2"></i>Mi Carrito
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Formulario oculto para logout móvil -->
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" title="Iniciar sesión">
                    <i class="fas fa-user-circle"></i>
                </a>
                @endauth
                
                <a href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge bg-secondary ms-1">{{ Cart::count() }}</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="py-1">
        @yield('content')
    </main>

    <!-- Footer -->
   <!-- Footer -->
<!-- Footer -->
<footer class="text-white pt-5 pb-4" style="background-color: #011904;">
    <div class="container">
        <div class="row">
            <!-- Logo & descripción -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-logo mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Meatology Logo" style="height: 40px; filter: brightness(0) invert(1);">
                </div>
                <h4 class="fw-bold text-uppercase mb-3">Meatology</h4>
                <p class="text-white small">
                    Premium grass-fed beef cuts, ethically sourced and delivered with care. Taste the tradition and quality from Uruguay to your table.
                </p>
                <div class="social-links mt-3">
                    
                    <a href="#" class="social-link me-3" title="Instagram">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                  
                    <a href="#" class="social-link" title="WhatsApp">
                        <i class="fab fa-whatsapp fa-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Navigation</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ route('shop.index') }}" class="footer-link">Products</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
                    <li><a href="{{ route('partner.chefs') }}" class="footer-link">Partner Chefs</a></li>
                </ul>
            </div>

            <!-- NUEVA SECCIÓN: Políticas y Servicios -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Policies</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('shipping.policy') }}" class="footer-link">Shipping Policy</a></li>
                    <li><a href="{{ route('return.policy') }}" class="footer-link">Return Policy</a></li>
                    <li><a href="{{ route('refund.policy') }}" class="footer-link">Refund Policy</a></li>
                    <li><a href="{{ route('terms.conditions') }}" class="footer-link">Terms & Conditions</a></li>
                </ul>
                
                <!-- Información de envío gratuito -->
              
            </div>

            <!-- Contact & Newsletter -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Stay Updated</h5>
                <p class="text-white small mb-3">
                    Subscribe to our newsletter for exclusive offers, recipes, and updates from our farms.
                </p>
       
                <!-- Contact Info -->
                <div class="contact-info mt-4">
                    <p class="text-white small mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:sales@meatology.us" class="footer-link">sales@meatology.us</a>
                    </p>
                    <p class="text-white small mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+13058420234" class="footer-link">+1 (305) 842-0234</a>
                    </p>
                    <p class="text-white small mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span class="text-white">Based in Florida</span>
                    </p>
                </div>
            </div>

            <!-- NUEVA SECCIÓN: Delivery Areas -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Delivery</h5>
                <div class="delivery-zones">
                    <div class="zone mb-3">
                        <h6 class="text-white mb-2">
                            <i class="fas fa-clock me-2 text-success"></i>
                            Same Day Delivery
                        </h6>
                        <p class="text-white small mb-1">Palm Beach County</p>
                        <p class="text-white small">Selected ZIP codes</p>
                    </div>
                    
                    <div class="zone mb-3">
                        <h6 class="text-white mb-2">
                            <i class="fas fa-shipping-fast me-2 text-warning"></i>
                            1-2 Days
                        </h6>
                        <p class="text-white small">Florida statewide</p>
                    </div>
                    
                    <div class="zone">
                        <h6 class="text-white mb-2">
                            <i class="fas fa-plane me-2 text-info"></i>
                            2-Day Air
                        </h6>
                        <p class="text-white small">All 50 States</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-light my-4 opacity-25">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="text-white small">
                    &copy; {{ date('Y') }} Meatology. All rights reserved.
                </div>
            </div>
            <div class="col-md-6">
                <div class="footer-certifications text-md-end">
                    <span class="certification-badge me-2">
                        <i class="fas fa-certificate text-success me-1"></i>
                        <small>Certified Humane®</small>
                    </span>
                    <span class="certification-badge me-2">
                        <i class="fas fa-leaf text-success me-1"></i>
                        <small>100% Grass-Fed</small>
                    </span>
                    <span class="certification-badge">
                        <i class="fas fa-shield-alt text-primary me-1"></i>
                        <small>Quality Guaranteed</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>

     function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            const menuIcon = document.getElementById('menuIcon');
            
            if (mobileNav.classList.contains('active')) {
                mobileNav.classList.remove('active');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.style.overflow = 'auto';
            } else {
                mobileNav.classList.add('active');
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
                document.body.style.overflow = 'hidden';
            }
        }

        // Cerrar menú móvil al hacer click en un enlace
        document.querySelectorAll('.mobile-nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                toggleMobileMenu();
            });
        });

        // Cerrar menú móvil al cambiar tamaño de pantalla
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                const mobileNav = document.getElementById('mobileNav');
                const menuIcon = document.getElementById('menuIcon');
                
                mobileNav.classList.remove('active');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.style.overflow = 'auto';
            }
        });
let currentImages = [];
let currentImageIndex = 0;

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('quickViewModal');
    
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            
            if (trigger) {
                const name = trigger.getAttribute('data-name');
                const desc = trigger.getAttribute('data-desc');
                const price = trigger.getAttribute('data-price');
                const weight = trigger.getAttribute('data-weight');
                const stock = trigger.getAttribute('data-stock');
                const category = trigger.getAttribute('data-category');
                const imagesData = trigger.getAttribute('data-images');
                const id = trigger.getAttribute('data-id');
                
                // Procesar imágenes
                try {
                    currentImages = JSON.parse(imagesData) || [];
                } catch (e) {
                    currentImages = [];
                }
                
                // Si no hay imágenes, usar placeholder
                if (currentImages.length === 0) {
                    currentImages = ["{{ asset('images/placeholder.jpg') }}"];
                }
                
                currentImageIndex = 0;
                setupImageGallery();
                
                // ===== RESTO DE VALIDACIONES (sin cambios) =====
                // Nombre
                const nameElement = document.getElementById('quickViewName');
                if (name && name.trim() !== '') {
                    nameElement.textContent = name;
                    nameElement.style.color = 'var(--accent)';
                } else {
                    nameElement.textContent = 'Product name not available';
                    nameElement.style.color = '#888';
                }
                
                // Descripción
                const descContainer = document.getElementById('quickViewDescriptionContainer');
                const descElement = document.getElementById('quickViewDescription');
                if (desc && desc.trim() !== '' && desc !== 'null') {
                    descElement.textContent = desc;
                    descContainer.style.display = 'block';
                } else {
                    descContainer.style.display = 'none';
                }
                
                // Precio
                const priceElement = document.getElementById('quickViewPrice');
                if (price && price !== '0' && price !== '' && price !== 'null') {
                    priceElement.textContent = `$${price}`;
                    priceElement.style.color = 'var(--highlight)';
                } else {
                    priceElement.textContent = 'Price not set';
                    priceElement.style.color = '#888';
                }
                
                // Stock
                const stockElement = document.getElementById('quickViewStock');
                const addToCartBtn = document.getElementById('addToCartBtn');
                
                if (stock !== null && stock !== '' && stock !== 'null') {
                    const stockValue = parseInt(stock) || 0;
                    
                    if (stockValue === 0) {
                        stockElement.textContent = 'Out of Stock';
                        stockElement.style.color = '#dc3545';
                        addToCartBtn.disabled = true;
                        addToCartBtn.innerHTML = '<i class="fas fa-times me-2"></i>Out of Stock';
                        addToCartBtn.style.backgroundColor = '#6c757d';
                    } else if (stockValue <= 5) {
                        stockElement.textContent = `${stockValue} units`;
                        stockElement.style.color = '#ffc107';
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                        addToCartBtn.style.backgroundColor = 'var(--highlight)';
                    } else {
                        stockElement.textContent = `${stockValue} units`;
                        stockElement.style.color = 'var(--accent)';
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                        addToCartBtn.style.backgroundColor = 'var(--highlight)';
                    }
                } else {
                    stockElement.textContent = 'Stock unknown';
                    stockElement.style.color = '#888';
                }
                
                // Peso
                const weightContainer = document.getElementById('weightContainer');
                const weightElement = document.getElementById('quickViewWeight');
                
                if (weight && weight.trim() !== '' && weight !== 'null') {
                    weightElement.textContent = weight;
                    weightContainer.style.display = 'block';
                } else {
                    weightContainer.style.display = 'none';
                }
                
                // Categoría
                const categoryBadge = document.getElementById('quickViewCategoryBadge');
                if (category && category.trim() !== '' && category !== 'N/A' && category !== 'null') {
                    categoryBadge.textContent = category;
                    categoryBadge.style.display = 'inline-block';
                } else {
                    categoryBadge.style.display = 'none';
                }
                
                // ID del producto
                const productIdElement = document.getElementById('quickViewProductId');
                if (id && id !== '' && id !== 'null') {
                    productIdElement.value = id;
                }
            }
        });
    }
});

function setupImageGallery() {
    const mainImage = document.getElementById('quickViewMainImage');
    const imageCounter = document.getElementById('imageCounter');
    const thumbnailContainer = document.getElementById('thumbnailContainer');
    const thumbnailImages = document.getElementById('thumbnailImages');
    const prevBtn = document.getElementById('prevImageBtn');
    const nextBtn = document.getElementById('nextImageBtn');
    
    // Mostrar imagen principal
    mainImage.src = currentImages[currentImageIndex];
    
    // Configurar contador y controles
    if (currentImages.length > 1) {
        imageCounter.textContent = `${currentImageIndex + 1} / ${currentImages.length}`;
        imageCounter.style.display = 'block';
        prevBtn.style.display = 'block';
        nextBtn.style.display = 'block';
        
        // Crear thumbnails
        thumbnailImages.innerHTML = '';
        currentImages.forEach((imageUrl, index) => {
            const thumbnail = document.createElement('img');
            thumbnail.src = imageUrl;
            thumbnail.className = 'img-thumbnail';
            thumbnail.style.cssText = `
                width: 60px; 
                height: 60px; 
                object-fit: cover; 
                cursor: pointer; 
                border: 2px solid ${index === currentImageIndex ? 'var(--highlight)' : 'var(--accent)'};
                opacity: ${index === currentImageIndex ? '1' : '0.7'};
                transition: all 0.3s ease;
            `;
            
            thumbnail.addEventListener('click', () => {
                currentImageIndex = index;
                setupImageGallery();
            });
            
            thumbnail.addEventListener('mouseenter', () => {
                if (index !== currentImageIndex) {
                    thumbnail.style.opacity = '1';
                }
            });
            
            thumbnail.addEventListener('mouseleave', () => {
                if (index !== currentImageIndex) {
                    thumbnail.style.opacity = '0.7';
                }
            });
            
            thumbnailImages.appendChild(thumbnail);
        });
        
        thumbnailContainer.style.display = 'block';
    } else {
        imageCounter.style.display = 'none';
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        thumbnailContainer.style.display = 'none';
    }
}

function changeImage(direction) {
    currentImageIndex += direction;
    
    if (currentImageIndex >= currentImages.length) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = currentImages.length - 1;
    }
    
    setupImageGallery();
}

// Navegación con teclado (opcional)
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('quickViewModal');
    if (modal.classList.contains('show')) {
        if (e.key === 'ArrowLeft') {
            changeImage(-1);
        } else if (e.key === 'ArrowRight') {
            changeImage(1);
        }
    }
});
</script>
</body>

</html>
