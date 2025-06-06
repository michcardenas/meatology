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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">




    <style>
       
    </style>
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Meatology Logo" >
        </div>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('shop.index') }}">Products</a>
            <a href="#">About Us</a>
            <a href="#">Insiders</a>
            <a href="#">Partner Chefs</a>
            <a href="#">Wholesale</a>
        </div>

    <div class="nav-icons">
            <a href="#" title="Buscar"><i class="fas fa-search"></i></a>

            @auth
                <a href="#" title="Mi cuenta"><i class="fas fa-user-circle"></i></a>
            @else
                <!-- <a href="{{ route('login') }}" title="Iniciar sesión"><i class="fas fa-user"></i></a> -->
            @endauth

                <a class="nav-link" href="{{ route('cart.index') }}">
                    🛒 <span class="badge bg-secondary">{{ Cart::count() }}</span>
                </a>
        </div>

    </nav>

    <main class="py-1">
        @yield('content')
    </main>

    <!-- Footer -->
<footer class="text-white pt-5 pb-4" style="background-color: #011904;">
    <div class="container">
        <div class="row">
            <!-- Logo & descripción -->
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold text-uppercase">Meatology</h4>
                <p class="text-light small">
                    Premium grass-fed beef cuts, ethically sourced and delivered with care. Taste the tradition and quality from Uruguay to your table.
                </p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#productos" class="text-light text-decoration-none">Shop</a></li>
                    <li><a href="#calidad" class="text-light text-decoration-none">Our Process</a></li>
                    <li><a href="#sostenibilidad" class="text-light text-decoration-none">Sustainability</a></li>
                    <li><a href="#contacto" class="text-light text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-semibold mb-3">Stay Updated</h5>
                <p class="text-light small">Subscribe to our newsletter for exclusive offers and recipes.</p>
                <form class="d-flex gap-2 mt-2">
                    <input type="email" class="form-control rounded-pill" placeholder="Email address">
                    <button type="submit" class="btn btn-success rounded-pill px-3">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-light my-4">

        <!-- Copyright -->
        <div class="text-center text-muted small">
            &copy; {{ date('Y') }} Meatology. All rights reserved.
        </div>
    </div>
</footer>

<script>
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
