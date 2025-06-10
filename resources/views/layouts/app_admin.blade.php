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
<meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSS y JS --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

@role('admin')
        @auth
 <div class="dropdown">
            <a class="dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                🛠️ Admin Panel
            </a>
            <ul class="dropdown-menu bg-dark border border-secondary">
                <li><a class="dropdown-item text-light" href="{{ route('admin.products.index') }}">🥩 Admin Products</a></li>
                <li><a class="dropdown-item text-light" href="{{ route('categories.index') }}">📂 Admin Categories</a></li>
                <li><a class="dropdown-item text-light" href="{{ route('admin.countries.index') }}">🌍 Manage Countries</a></li>
                <li><a class="dropdown-item text-light" href="{{ route('admin.cities.index') }}">🏙️ Manage Cities</a></li>
            </ul>
        </div>
@endauth
@endrole

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
 <script>
function deleteImageAjax(imageId) {
    if (confirm('⚠️ Are you sure you want to delete this image? This action cannot be undone.')) {
        // Mostrar indicador de carga
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Deleting...';
        button.disabled = true;

        // Realizar petición AJAX
        fetch(`/admin/products/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Eliminar el elemento del DOM con animación
                const imageElement = document.getElementById(`image-${imageId}`);
                imageElement.style.transition = 'opacity 0.3s ease';
                imageElement.style.opacity = '0';
                
                setTimeout(() => {
                    imageElement.remove();
                    // Actualizar contador de imágenes
                    updateImageCounter();
                }, 300);
                
                // Mostrar mensaje de éxito (opcional)
                showToast('Image deleted successfully', 'success');
            } else {
                throw new Error(data.message || 'Error deleting image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Restaurar botón en caso de error
            button.innerHTML = originalText;
            button.disabled = false;
            showToast('Error deleting image', 'error');
        });
    }
}

function updateImageCounter() {
    const container = document.getElementById('images-container');
    const imageCount = container.children.length;
    const counterElement = container.parentElement.querySelector('small');
    
    if (imageCount === 0) {
        counterElement.style.display = 'none';
    } else {
        counterElement.textContent = `Currently has ${imageCount} image${imageCount > 1 ? 's' : ''}`;
    }
}

function showToast(message, type) {
    // Crear toast simple
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
</body>
</html>
