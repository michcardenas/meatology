@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color: #011904; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Header del Usuario -->
            <div class="card border-0 mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-white mb-1 fw-bold">🛒 Welcome {{ $user->name }}</h2>
                            <p class="text-white-50 mb-0 fs-5">
                                <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-white mb-3"></i>
                            <h3 class="text-white fw-bold mb-2">{{ $orders->count() }}</h3>
                            <p class="text-white mb-0 fs-6 fw-semibold">Total Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #198754, #157347);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-white mb-3"></i>
                            <h3 class="text-white fw-bold mb-2">{{ $orders->where('status', 'completed')->count() }}</h3>
                            <p class="text-white mb-0 fs-6 fw-semibold">Completed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #ffc107, #ffca2c);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-clock fa-3x text-dark mb-3"></i>
                            <h3 class="text-dark fw-bold mb-2">{{ $orders->where('status', 'pending')->count() }}</h3>
                            <p class="text-dark mb-0 fs-6 fw-semibold">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #0dcaf0, #31d2f2);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-dollar-sign fa-3x text-dark mb-3"></i>
                            <h3 class="text-dark fw-bold mb-2">${{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</h3>
                            <p class="text-dark mb-0 fs-6 fw-semibold">Total Spent</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-light border-3 my-5" style="opacity: 0.3;">

            <h4 class="text-white mb-4 fw-bold fs-2">
                📦 Your Orders
                <span class="badge bg-success ms-3 fs-6">{{ $orders->count() }} orders</span>
            </h4>

            @if($orders->isEmpty())
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-white mb-4" style="opacity: 0.7;"></i>
                        <h5 class="text-white mb-3 fw-bold fs-4">No orders yet</h5>
                        <p class="text-white-50 mb-4 fs-5">You haven't made any orders yet. Start shopping now!</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-4 py-3 shadow">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            @else
                <div class="accordion" id="ordersAccordion">
                    @foreach($orders as $index => $order)
                    <div class="card border-0 shadow-lg mb-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <div class="card-header border-0" id="heading{{ $index }}" style="background: rgba(255,255,255,0.1);">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-link text-white text-decoration-none p-0 me-3 fs-5" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $index }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $index }}">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div>
                                        <h6 class="mb-1 text-white fw-bold fs-5">
                                            <i class="fas fa-receipt me-2 text-success"></i>
                                            Order #{{ $order->order_number }}
                                        </h6>
                                        <small class="text-white-50 fs-6">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $order->created_at->format('M d, Y - g:i A') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge fs-6 mb-2 px-3 py-2 {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="text-white fw-bold fs-4">
                                        ${{ number_format($order->total_amount, 2, '.', ',') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="collapse{{ $index }}" 
                             class="collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" 
                             data-bs-parent="#ordersAccordion">
                            <div class="card-body" style="background: rgba(255,255,255,0.05);">
                                <!-- Información de la Orden -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-white mb-3 fw-bold fs-5">
                                            <i class="fas fa-info-circle me-2 text-success"></i>Order Details
                                        </h6>
                                        <p class="text-white-50 mb-2 fs-6">
                                            <strong class="text-white">Payment Status:</strong> 
                                            <span class="badge ms-2 px-3 py-2 {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                        @if($order->payment_method)
                                            <p class="text-white-50 mb-2 fs-6">
                                                <strong class="text-white">Payment Method:</strong> {{ ucfirst($order->payment_method) }}
                                            </p>
                                        @endif
                                        @if($order->customer_phone)
                                            <p class="text-white-50 mb-2 fs-6">
                                                <strong class="text-white">Phone:</strong> {{ $order->customer_phone }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-white mb-3 fw-bold fs-5">
                                            <i class="fas fa-shipping-fast me-2 text-success"></i>Shipping Address
                                        </h6>
                                        <p class="text-white-50 mb-2 fs-6">{{ $order->customer_address }}</p>
                                        @if($order->city || $order->country)
                                            <p class="text-white-50 mb-2 fs-6">
                                                @if($order->city) {{ $order->city->name }}, @endif
                                                @if($order->country) {{ $order->country->name }} @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items de la Orden -->
                                @if($order->items->count() > 0)
                                    <h6 class="text-white mb-3 fw-bold fs-5">
                                        <i class="fas fa-list me-2 text-success"></i>Order Items ({{ $order->items->count() }})
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless custom-white-table">
                                            <thead style="background: rgba(255,255,255,0.1);">
                                                <tr>
                                                    <th class="text-white fw-bold fs-6 custom-white-text">Product</th>
                                                    <th class="text-center text-white fw-bold fs-6 custom-white-text">Quantity</th>
                                                    <th class="text-end text-white fw-bold fs-6 custom-white-text">Unit Price</th>
                                                    <th class="text-end text-white fw-bold fs-6 custom-white-text">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);" class="custom-white-row">
                                                    <td class="py-3 custom-white-text">
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product && $item->product->images->first())
                                                                <img src="{{ Storage::url($item->product->images->first()->image) }}" 
                                                                     alt="{{ $item->product_name }}" 
                                                                     class="me-3 rounded shadow"
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="me-3 bg-secondary rounded d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-image text-white"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="text-white fw-semibold fs-6 custom-white-text">{{ $item->product_name }}</div>
                                                                @if($item->product)
                                                                    <small class="text-white-50 custom-white-text" style="color: rgba(255,255,255,0.7) !important;">SKU: {{ $item->product->id }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center py-3 custom-white-text">
                                                        <span class="badge bg-success px-3 py-2 fs-6" style="color: white !important;">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td class="text-end py-3 fs-6 custom-white-text" style="color: white !important;">${{ number_format($item->product_price, 2) }}</td>
                                                    <td class="text-end fw-bold py-3 fs-5 custom-white-text" style="color: white !important;">${{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <!-- Resumen de Totales -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="border-top border-light pt-4 custom-white-section" style="border-opacity: 0.3 !important;">
                                            <div class="d-flex justify-content-between mb-2 fs-6 custom-white-text">
                                                <span class="custom-white-text" style="color: rgba(255,255,255,0.8) !important;">Subtotal:</span>
                                                <span class="custom-white-text" style="color: white !important;">${{ number_format($order->subtotal, 2) }}</span>
                                            </div>
                                            @if($order->tax_amount > 0)
                                                <div class="d-flex justify-content-between mb-2 fs-6 custom-white-text">
                                                    <span class="custom-white-text" style="color: rgba(255,255,255,0.8) !important;">Tax:</span>
                                                    <span class="custom-white-text" style="color: white !important;">${{ number_format($order->tax_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($order->shipping_amount > 0)
                                                <div class="d-flex justify-content-between mb-2 fs-6 custom-white-text">
                                                    <span class="custom-white-text" style="color: rgba(255,255,255,0.8) !important;">Shipping:</span>
                                                    <span class="custom-white-text" style="color: white !important;">${{ number_format($order->shipping_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            <hr class="border-light" style="border-opacity: 0.5 !important;">
                                            <div class="d-flex justify-content-between fw-bold fs-4 custom-white-text">
                                                <span class="custom-white-text" style="color: white !important;">Total:</span>
                                                <span class="text-success custom-white-text" style="color: #28a745 !important;">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($order->notes)
                                    <div class="mt-4 p-3 rounded custom-white-section" style="background: rgba(255,255,255,0.1);">
                                        <h6 class="mb-2 fw-bold custom-white-text" style="color: white !important;">
                                            <i class="fas fa-sticky-note me-2 text-success"></i>Notes
                                        </h6>
                                        <p class="mb-0 fs-6 custom-white-text" style="color: rgba(255,255,255,0.8) !important;">{{ $order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Estilos personalizados para el dashboard del comprador */
body {
    background-color: #011904 !important;
}

/* MÁXIMA ESPECIFICIDAD PARA FORZAR TEXTO BLANCO */
.custom-white-text,
.custom-white-text *,
.custom-white-row,
.custom-white-row *,
.custom-white-table,
.custom-white-table *,
.custom-white-section,
.custom-white-section * {
    color: white !important;
}

/* SUPER ESPECÍFICO PARA SOBREESCRIBIR BOOTSTRAP */
table.custom-white-table thead th,
table.custom-white-table tbody td,
table.custom-white-table tbody tr,
table.custom-white-table thead tr,
.table.custom-white-table th,
.table.custom-white-table td,
.table.custom-white-table tr {
    color: white !important;
    border-color: rgba(255,255,255,0.2) !important;
    background-color: transparent !important;
}

/* FORZAR TODOS LOS TEXTOS A SER VISIBLES CON SELECTORES MÚLTIPLES */
.container, 
.container *,
.card,
.card *,
.accordion,
.accordion *,
div,
span,
p,
small,
strong,
b,
h1, h2, h3, h4, h5, h6 {
    color: white !important;
}

/* SELECTORES DE ATRIBUTO PARA MAYOR ESPECIFICIDAD */
[class*="text-"],
[class*="custom-white"] {
    color: white !important;
}

/* CLASES BOOTSTRAP ESPECÍFICAS */
.text-muted,
.text-secondary,
.text-light,
.text-white,
.text-white-50 {
    color: rgba(255,255,255,0.8) !important;
}

/* EXCEPCIONES PARA BADGES CON FONDO CLARO */
.badge.bg-warning,
.badge.bg-warning *,
.btn.btn-warning,
.btn.btn-warning * {
    color: #000 !important;
}

/* TODOS LOS OTROS BADGES EN BLANCO */
.badge:not(.bg-warning),
.badge:not(.bg-warning) * {
    color: white !important;
}

/* ELEMENTOS DE TABLA CON MÁXIMA ESPECIFICIDAD */
table th,
table td,
table thead,
table tbody,
table tfoot,
.table th,
.table td,
.table thead,
.table tbody,
.table tfoot,
thead th,
tbody td,
tbody tr,
thead tr {
    color: white !important;
    border-color: rgba(255,255,255,0.2) !important;
}

/* ACORDEÓN ESPECÍFICO */
.accordion .btn-link {
    text-decoration: none !important;
    transition: all 0.3s ease;
    color: white !important;
}

.accordion .btn-link:focus,
.accordion .btn-link:hover,
.accordion .btn-link:visited,
.accordion .btn-link:active {
    box-shadow: none;
    color: white !important;
}

.accordion .card-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.accordion .collapse.show {
    border-top: 1px solid rgba(255,255,255,0.1);
}

/* LINKS */
a:not(.btn):not(.badge) {
    color: #28a745 !important;
}

a:not(.btn):not(.badge):hover {
    color: #34ce57 !important;
}

/* CARDS */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
}

/* BADGES CON CONTRASTE CORRECTO */
.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge.bg-success,
.badge.bg-success * {
    background-color: #28a745 !important;
    color: white !important;
}

.badge.bg-danger,
.badge.bg-danger * {
    background-color: #dc3545 !important;
    color: white !important;
}

.badge.bg-info,
.badge.bg-info * {
    background-color: #17a2b8 !important;
    color: white !important;
}

.badge.bg-secondary,
.badge.bg-secondary * {
    background-color: #6c757d !important;
    color: white !important;
}

/* HOVER EFFECTS */
.row .col-md-3 .card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3) !important;
}

/* TRANSICIONES */
* {
    transition: all 0.3s ease;
}

/* ELEMENTOS CRÍTICOS CON MÁXIMA ESPECIFICIDAD */
body .container .card .card-body div span,
body .container .card .card-body div p,
body .container .card .card-body div small,
body .container .card .card-body div strong,
body .container table tbody tr td,
body .container table thead tr th {
    color: white !important;
}

/* LAST RESORT - USAR !important EN TODO */
* {
    color: white !important;
}

/* EXCEPCIONES FINALES PARA ELEMENTOS QUE NECESITAN SER OSCUROS */
.badge.bg-warning,
.badge.bg-light,
.btn.btn-warning,
.btn.btn-light,
.alert.alert-warning,
.alert.alert-light {
    color: #000 !important;
}

/* ASEGURAR QUE LOS PRECIOS Y NÚMEROS SEAN VISIBLES */
.price,
.amount,
.total,
[class*="price"],
[class*="amount"],
[class*="total"] {
    color: white !important;
}
</style>

@endsection