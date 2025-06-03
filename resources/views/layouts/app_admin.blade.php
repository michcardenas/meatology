<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meatology</title>


    {{-- Favicon y meta para iconos --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">

    {{-- CSS y JS --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">




    <style>
       
    </style>
    @vite(['resources/js/app.js'])
</head>
<body>
 <nav class="d-flex justify-content-between align-items-center p-3 border-bottom">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Meatology Logo" height="50">
    </div>

    <div class="nav-links d-flex gap-4 align-items-center">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('shop.index') }}">Products</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('insiders') }}">Insiders</a>
        <a href="{{ route('chefs') }}">Partner Chefs</a>
        <a href="{{ route('wholesale') }}">Wholesale</a>

        @auth
    <div class="dropdown">
        <a class="dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            🛠️ Admin Panel
        </a>
        <ul class="dropdown-menu bg-dark border border-secondary">
            <li><a class="dropdown-item text-light" href="{{ route('admin.products.index') }}">🥩 Admin Products</a></li>
            <li><a class="dropdown-item text-light" href="{{ route('categories.index') }}">📂 Admin Categories</a></li>
        </ul>
    </div>
@endauth

    </div>

    <div class="nav-icons d-flex gap-3 align-items-center">
        <a href="#" title="Buscar"><i class="fas fa-search"></i></a>

        @auth
            <a href="{{ route('dashboard') }}" title="Mi cuenta"><i class="fas fa-user-circle"></i></a>
        @else
            <a href="{{ route('login') }}" title="Iniciar sesión"><i class="fas fa-user"></i></a>
        @endauth

        <a href="{{ route('cart.index') }}" class="position-relative" title="Carrito">
            🛒
            <span class="badge bg-secondary position-absolute top-0 start-100 translate-middle">
                {{ Cart::count() }}
            </span>
        </a>
    </div>
</nav>


    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
