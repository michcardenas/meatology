@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #000; /* fondo oscuro total */
        color: #fff;
    }

    .catalog-title {
        color: #f7a831;
        font-weight: bold;
        font-size: 2.5rem;
    }

    .sidebar {
        background-color: #111;
        padding: 20px;
        border-right: 1px solid #222;
    }

    .sidebar h5 {
        font-size: 1rem;
        color: #aaa;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
        margin-top: 20px;
    }

    .catalog-container {
        display: flex;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding-left: 30px;
    }

    .product-card {
        background-color: #1a1a1a;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 0 10px #f7a83133;
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
        color: #fff;
        margin-bottom: 10px;
    }

    .product-info p {
        color: #ccc;
        font-size: 0.9rem;
    }

    .product-price {
        font-size: 1.2rem;
        color: #f7a831;
        font-weight: bold;
        margin-top: 10px;
    }

    .btn-buy {
        background-color: #f7a831;
        color: #000;
        border: none;
        font-weight: bold;
        width: 100%;
    }

    .btn-buy:hover {
        background-color: #e69b1f;
    }
</style>

<div class="container-fluid py-5">
    <h1 class="text-center catalog-title mb-4">Catálogo Meatology 🥩</h1>

    <div class="catalog-container">
        <!-- Sidebar -->
        <div class="sidebar col-md-3">
            <h5>STOCK STATUS</h5>
            <h5>PRODUCT TYPE</h5>
            <h5>PRODUCT AVAILABILITY</h5>
            <h5>HOW IT ARRIVES</h5>
            <h5>COUNTRY OF ORIGIN</h5>
        </div>

        <!-- Productos -->
        <div class="product-grid col-md-9">
            @foreach ($products as $product)
           <div class="product-card position-relative text-center">
    <div class="product-image-wrapper position-relative overflow-hidden">
        <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}"
             alt="{{ $product->name }}" class="img-fluid product-image">
        
        <div class="quick-view-overlay">
            <span class="quick-view-text">Quick View</span>
        </div>
    </div>

    <div class="product-info mt-3">
        <h5 class="mb-1">{{ $product->name }}</h5>
        <div class="product-price">${{ number_format($product->price, 0) }}</div>

        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="btn btn-buy">Add to Cart</button>
        </form>
    </div>
</div>

            @endforeach
        </div>
    </div>

    <div class="mt-5 text-center">
        {{ $products->links() }}
    </div>
</div>

@endsection
