@extends('layouts.app')

@section('content')
<style>
/* 🔥 FONDO BLANCO COMPLETO - Sobrescribir cualquier estilo heredado */
body {
    background-color: #ffffff !important;
}

.container {
    background-color: #ffffff !important;
}

/* Asegurar que toda la página tenga fondo blanco */
main {
    background-color: #ffffff !important;
}

/* Cards del carrito con fondo blanco sólido */
.card {
    background-color: #ffffff !important;
    border: 1px solid rgba(1, 25, 4, 0.15);
}

.card-body {
    background-color: #ffffff !important;
}

.card.border-success {
    border: 2px solid #2d5016 !important;
    background-color: #ffffff !important;
}

/* Header de descuento */
.card-header {
    background-color: #f8f9fa !important;
}

.card-header.bg-success {
    background-color: #2d5016 !important;
    color: #ffffff !important;
}

.card-header.bg-success.bg-opacity-10 {
    background-color: rgba(45, 80, 22, 0.1) !important;
}

/* Títulos y textos principales */
h2, h3, h4, h5, h6 {
    color: #011904 !important;
}

/* Textos */
.text-muted {
    color: #6c757d !important;
}

.text-success {
    color: #2d5016 !important;
}

.text-dark {
    color: #011904 !important;
}

/* Botones */
.btn-success {
    background-color: #2d5016 !important;
    border-color: #2d5016 !important;
    color: #ffffff !important;
}

.btn-success:hover {
    background-color: #011904 !important;
    border-color: #011904 !important;
}

.btn-primary {
    background-color: #2d5016 !important;
    border-color: #2d5016 !important;
    color: #ffffff !important;
}

.btn-primary:hover {
    background-color: #011904 !important;
    border-color: #011904 !important;
}

/* Badges */
.badge.bg-success {
    background-color: #2d5016 !important;
    color: #ffffff !important;
}

/* Alertas */
.alert-success {
    background-color: rgba(45, 80, 22, 0.1) !important;
    border-color: #2d5016 !important;
    color: #011904 !important;
}

.alert-info {
    background-color: rgba(1, 25, 4, 0.05) !important;
    border-color: rgba(1, 25, 4, 0.2) !important;
    color: #011904 !important;
}

/* Fondos de descuento */
.bg-success.bg-opacity-10 {
    background-color: rgba(45, 80, 22, 0.1) !important;
}

/* Textos en negrita */
strong {
    color: #011904 !important;
}

/* Formularios */
.form-control {
    border-color: rgba(1, 25, 4, 0.2);
    background-color: #ffffff !important;
}

.form-control:focus {
    border-color: #2d5016;
    box-shadow: 0 0 0 0.25rem rgba(45, 80, 22, 0.25);
    background-color: #ffffff !important;
}

/* Asegurar que los rows también tengan fondo blanco */
.row {
    background-color: transparent !important;
}

/* Contenedor del carrito */
.cart-container {
    background-color: #ffffff !important;
    padding: 20px;
    border-radius: 8px;
}
</style>

<div class="container py-4 cart-container">
    {{-- Header con indicador de descuentos --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark">🛒 Your Shopping Cart</h2>
        @if(isset($totalSavings) && $totalSavings > 0)
            <div class="badge bg-success fs-6 px-3 py-2">
                🏷️ You have active discounts!
            </div>
        @endif
    </div>
    
    @if(Cart::count() > 0)
        <div class="row">
            <div class="col-md-8">
                @foreach(Cart::content() as $item)
                    <div class="card mb-3 {{ isset($item->options->descuento) && $item->options->descuento > 0 ? 'border-success' : '' }}">
                        @if(isset($item->options->descuento) && $item->options->descuento > 0)
                            <div class="card-header bg-success bg-opacity-10 py-2">
                                <small class="text-success fw-bold">
                                    🎉 DISCOUNT APPLIED: {{ $item->options->descuento }}% OFF
                                </small>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <img src="{{ $item->options->image ? Storage::url($item->options->image) : asset('images/placeholder.jpg') }}" 
                                             class="img-fluid rounded" alt="{{ $item->name }}">
                                        @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                            <span class="position-absolute top-0 start-0 badge bg-danger m-1 small">
                                                -{{ $item->options->descuento }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="mb-0 text-dark">{{ $item->name }}</h5>
                                        {{-- Badge de Descuento --}}
                                        @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                            <span class="badge bg-danger">-{{ $item->options->descuento }}% OFF</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block">{{ $item->options->category_name }}</small>

                                    <small class="d-block text-muted">
                                        Base price: ${{ number_format($item->options->base_price, 2, '.', ',') }}
                                    </small>
                                    <small class="d-block text-muted">
                                        Interest: ${{ number_format($item->options->interest, 2, '.', ',') }}
                                    </small>

                                    {{-- Mostrar información de descuento --}}
                                    @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                        <div class="p-2 bg-success bg-opacity-10 rounded mt-2">
                                            <small class="d-block text-muted text-decoration-line-through">
                                                Original: ${{ number_format($item->options->original_price, 2, '.', ',') }}
                                            </small>
                                            <small class="d-block text-success fw-bold">
                                                You save: ${{ number_format($item->options->discount_amount, 2, '.', ',') }}
                                            </small>
                                            <small class="d-block fw-bold text-danger">
                                                Final price: ${{ number_format($item->price, 2, '.', ',') }}
                                            </small>
                                        </div>
                                    @else
                                        <small class="d-block fw-bold text-dark">
                                            Unit total: ${{ number_format($item->price, 2, '.', ',') }}
                                        </small>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                        <div class="text-center">
                                            <div class="text-muted text-decoration-line-through small">
                                                ${{ number_format($item->options->original_price, 2, '.', ',') }}
                                            </div>
                                            <strong class="text-danger fs-5">${{ number_format($item->price, 2, '.', ',') }}</strong>
                                            <div class="badge bg-success small">
                                                Save ${{ number_format($item->options->discount_amount, 2, '.', ',') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <strong class="fs-5 text-dark">${{ number_format($item->price, 2, '.', ',') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="qty" value="{{ $item->qty }}" 
                                               min="0" max="{{ $item->options->stock }}" 
                                               class="form-control form-control-sm me-2" style="width: 70px;"
                                               onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div class="col-md-2 text-end">
                                    @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                        @php
                                            $originalTotal = ($item->options->original_price * $item->qty);
                                            $itemSavings = ($item->options->discount_amount * $item->qty);
                                        @endphp
                                        <div class="text-muted text-decoration-line-through small">
                                            ${{ number_format($originalTotal, 2, '.', ',') }}
                                        </div>
                                        <strong class="text-danger fs-5">${{ number_format($item->total, 2, '.', ',') }}</strong>
                                        <div class="text-success small fw-bold">
                                            💰 Save: ${{ number_format($itemSavings, 2, '.', ',') }}
                                        </div>
                                    @else
                                        <strong class="fs-5 text-dark">${{ number_format($item->total, 2, '.', ',') }}</strong>
                                    @endif
                                    <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-2">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="col-md-4">
                <div class="card {{ isset($totalSavings) && $totalSavings > 0 ? 'border-success' : '' }}">
                    @if(isset($totalSavings) && $totalSavings > 0)
                        <div class="card-header bg-success text-white text-center">
                            <strong>🎉 DISCOUNT SUMMARY 🎉</strong>
                        </div>
                    @else
                        <div class="card-header">
                            <h5 class="mb-0 text-dark">Order Summary</h5>
                        </div>
                    @endif
                    <div class="card-body">
                        {{-- Mostrar ahorros destacados --}}
                        @if(isset($totalSavings) && $totalSavings > 0)
                            <div class="alert alert-success text-center mb-3">
                                <h4 class="mb-2 text-dark">🏷️ TOTAL SAVINGS</h4>
                                <h3 class="text-success mb-0">
                                    ${{ number_format($totalSavings, 2, '.', ',') }}
                                </h3>
                                <small class="text-dark">You're getting a great deal!</small>
                            </div>
                            
                            <div class="d-flex justify-content-between text-muted text-decoration-line-through">
                                <span>Original subtotal:</span>
                                <span>${{ number_format($originalSubtotal, 2, '.', ',') }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-success fw-bold">
                                <span>Your discount:</span>
                                <span>-${{ number_format($totalSavings, 2, '.', ',') }}</span>
                            </div>
                            <hr class="my-2">
                        @endif

                        <div class="d-flex justify-content-between text-dark">
                            <span>Subtotal:</span>
                            <span>${{ number_format((float)str_replace(',', '', Cart::subtotal()), 2, '.', ',') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-dark">
                            <span>Tax:</span>
                            <span>${{ number_format((float)str_replace(',', '', Cart::tax()), 2, '.', ',') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong class="fs-5 text-dark">Total:</strong>
                            <strong class="fs-5 text-dark">${{ number_format((float)str_replace(',', '', Cart::total()), 2, '.', ',') }}</strong>
                        </div>

                        @if(isset($totalSavings) && $totalSavings > 0)
                            <div class="alert alert-info mt-3 py-2 text-center">
                                <small class="text-dark"><strong>🎯 Smart shopping!</strong><br>
                                You saved ${{ number_format($totalSavings, 2, '.', ',') }} on this order</small>
                            </div>
                        @endif
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mt-3 py-2">
                            <strong>Proceed to Checkout</strong>
                            @if(isset($totalSavings) && $totalSavings > 0)
                                <br><small>With ${{ number_format($totalSavings, 2, '.', ',') }} savings!</small>
                            @endif
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary w-100" 
                                    onclick="return confirm('Are you sure you want to empty the cart?')">
                                Empty Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="text-dark">Your cart is empty</h4>
            <p class="text-muted">Add some delicious products!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection