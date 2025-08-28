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
                                        <table class="table table-borderless">
                                            <thead style="background: rgba(255,255,255,0.1);">
                                                <tr>
                                                    <th class="text-white fw-bold fs-6">Product</th>
                                                    <th class="text-center text-white fw-bold fs-6">Quantity</th>
                                                    <th class="text-end text-white fw-bold fs-6">Unit Price</th>
                                                    <th class="text-end text-white fw-bold fs-6">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                                    <td class="py-3">
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
                                                                <div class="text-white fw-semibold fs-6">{{ $item->product_name }}</div>
                                                                @if($item->product)
                                                                    <small class="text-white-50">SKU: {{ $item->product->id }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center py-3">
                                                        <span class="badge bg-success px-3 py-2 fs-6">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td class="text-end text-white py-3 fs-6">${{ number_format($item->product_price, 2) }}</td>
                                                    <td class="text-end text-white fw-bold py-3 fs-5">${{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <!-- Resumen de Totales -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="border-top border-light pt-4" style="border-opacity: 0.3 !important;">
                                            <div class="d-flex justify-content-between text-white-50 mb-2 fs-6">
                                                <span>Subtotal:</span>
                                                <span class="text-white">${{ number_format($order->subtotal, 2) }}</span>
                                            </div>
                                            @if($order->tax_amount > 0)
                                                <div class="d-flex justify-content-between text-white-50 mb-2 fs-6">
                                                    <span>Tax:</span>
                                                    <span class="text-white">${{ number_format($order->tax_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($order->shipping_amount > 0)
                                                <div class="d-flex justify-content-between text-white-50 mb-2 fs-6">
                                                    <span>Shipping:</span>
                                                    <span class="text-white">${{ number_format($order->shipping_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            <hr class="border-light" style="border-opacity: 0.5 !important;">
                                            <div class="d-flex justify-content-between text-white fw-bold fs-4">
                                                <span>Total:</span>
                                                <span class="text-success">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($order->notes)
                                    <div class="mt-4 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                        <h6 class="text-white mb-2 fw-bold">
                                            <i class="fas fa-sticky-note me-2 text-success"></i>Notes
                                        </h6>
                                        <p class="text-white-50 mb-0 fs-6">{{ $order->notes }}</p>
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

.accordion .btn-link {
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.accordion .btn-link:focus {
    box-shadow: none;
}

.accordion .btn-link:hover {
    opacity: 0.8;
    transform: scale(1.1);
}

.accordion .card-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.accordion .collapse.show {
    border-top: 1px solid rgba(255,255,255,0.1);
}

.table th,
.table td {
    border: none !important;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
}

.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Animaciones sutiles */
.accordion .collapse {
    transition: all 0.3s ease;
}

/* Glass effect mejorado */
.card {
    border: 1px solid rgba(255,255,255,0.1);
}

/* Mejorar la visibilidad del texto */
.text-white-50 {
    color: rgba(255,255,255,0.8) !important;
}

/* Hover effects para las estadísticas */
.row .col-md-3 .card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3) !important;
}

/* Efectos de transición suaves */
* {
    transition: all 0.3s ease;
}
</style>

@endsection