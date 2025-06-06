@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛒 Tu Carrito de Compras</h2>
    
    @if(Cart::count() > 0)
        <div class="row">
            <div class="col-md-8">
                @foreach(Cart::content() as $item)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ $item->options->image ? Storage::url($item->options->image) : asset('images/placeholder.jpg') }}" 
                                         class="img-fluid rounded" alt="{{ $item->name }}">
                                </div>
                                <div class="col-md-4">
                                    <h5>{{ $item->name }}</h5>
                                    <small class="text-muted">{{ $item->options->category_name }}</small>
                                </div>
                                <div class="col-md-2">
                                    <strong>${{ number_format($item->price, 0) }}</strong>
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
                                    <strong>${{ number_format($item->total, 0) }}</strong>
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
                <div class="card">
                    <div class="card-header">
                        <h5>Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span>${{ Cart::subtotal() }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Impuestos:</span>
                            <span>${{ Cart::tax() }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>${{ Cart::total() }}</strong>
                        </div>
                        
                        <button class="btn btn-success w-100 mt-3">Proceder al Checkout</button>
                        
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary w-100" 
                                    onclick="return confirm('¿Estás seguro de vaciar el carrito?')">
                                Vaciar Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4>Tu carrito está vacío</h4>
            <p>¡Agrega algunos productos deliciosos!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continuar Comprando</a>
        </div>
    @endif
</div>
@endsection