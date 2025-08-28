@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color: #011904; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Header del Usuario con verificación null -->
            <div class="card border-0 mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-white mb-1 fw-bold" style="color: white !important;">
                                🛒 Welcome {{ $user->name ?? 'Guest User' }}
                            </h2>
                            <p class="text-white-50 mb-0 fs-5" style="color: rgba(255,255,255,0.8) !important;">
                                <i class="fas fa-envelope me-2"></i>{{ $user->email ?? 'No email provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas con verificación null -->
            @if(isset($orders) && $orders)
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-white mb-3"></i>
                            <h3 class="text-white fw-bold mb-2" style="color: white !important;">{{ $orders->count() }}</h3>
                            <p class="text-white mb-0 fs-6 fw-semibold" style="color: white !important;">Total Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #198754, #157347);">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-white mb-3"></i>
                            <h3 class="text-white fw-bold mb-2" style="color: white !important;">{{ $orders->where('status', 'completed')->count() }}</h3>
                            <p class="text-white mb-0 fs-6 fw-semibold" style="color: white !important;">Completed</p>
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
            @endif

            <hr class="border-light border-3 my-5" style="opacity: 0.3;">

            <h4 class="text-white mb-4 fw-bold fs-2" style="color: white !important;">
                📦 Your Orders
                @if(isset($orders) && $orders)
                    <span class="badge bg-success ms-3 fs-6" style="color: white !important;">{{ $orders->count() }} orders</span>
                @endif
            </h4>

            @if(!isset($orders) || $orders->isEmpty())
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-white mb-4" style="opacity: 0.7; color: white !important;"></i>
                        <h5 class="text-white mb-3 fw-bold fs-4" style="color: white !important;">No orders yet</h5>
                        <p class="text-white-50 mb-4 fs-5" style="color: rgba(255,255,255,0.8) !important;">You haven't made any orders yet. Start shopping now!</p>
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
                                            aria-controls="collapse{{ $index }}"
                                            style="color: white !important;">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div>
                                        <h6 class="mb-1 text-white fw-bold fs-5" style="color: white !important;">
                                            <i class="fas fa-receipt me-2 text-success"></i>
                                            Order #{{ $order->order_number ?? 'N/A' }}
                                        </h6>
                                        <small class="text-white-50 fs-6" style="color: rgba(255,255,255,0.8) !important;">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ optional($order->created_at)->format('M d, Y - g:i A') ?? 'Date not available' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge fs-6 mb-2 px-3 py-2 {{ ($order->status ?? '') === 'completed' ? 'bg-success' : (($order->status ?? '') === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}"
                                          style="{{ ($order->status ?? '') === 'pending' ? 'color: #000 !important;' : 'color: white !important;' }}">
                                        {{ ucfirst($order->status ?? 'Unknown') }}
                                    </span>
                                    <div class="text-white fw-bold fs-4" style="color: white !important;">
                                        ${{ number_format($order->total_amount ?? 0, 2, '.', ',') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="collapse{{ $index }}" 
                             class="collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" 
                             data-bs-parent="#ordersAccordion">
                            <div class="card-body" style="background: rgba(255,255,255,0.05);">
                                <!-- Información de la Orden con verificación null -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-white mb-3 fw-bold fs-5" style="color: white !important;">
                                            <i class="fas fa-info-circle me-2 text-success"></i>Order Details
                                        </h6>
                                        <p class="text-white-50 mb-2 fs-6" style="color: rgba(255,255,255,0.8) !important;">
                                            <strong class="text-white" style="color: white !important;">Payment Status:</strong> 
                                            <span class="badge ms-2 px-3 py-2 {{ ($order->payment_status ?? '') === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}"
                                                  style="{{ ($order->payment_status ?? '') === 'paid' ? 'color: white !important;' : 'color: #000 !important;' }}">
                                                {{ ucfirst($order->payment_status ?? 'Unknown') }}
                                            </span>
                                        </p>
                                        @if($order->payment_method ?? false)
                                            <p class="text-white-50 mb-2 fs-6" style="color: rgba(255,255,255,0.8) !important;">
                                                <strong class="text-white" style="color: white !important;">Payment Method:</strong> {{ ucfirst($order->payment_method) }}
                                            </p>
                                        @endif
                                        @if($order->customer_phone ?? false)
                                            <p class="text-white-50 mb-2 fs-6" style="color: rgba(255,255,255,0.8) !important;">
                                                <strong class="text-white" style="color: white !important;">Phone:</strong> {{ $order->customer_phone }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-white mb-3 fw-bold fs-5" style="color: white !important;">
                                            <i class="fas fa-shipping-fast me-2 text-success"></i>Shipping Address
                                        </h6>
                                        <p class="text-white-50 mb-2 fs-6" style="color: rgba(255,255,255,0.8) !important;">{{ $order->customer_address ?? 'No address provided' }}</p>
                                        @if(($order->city ?? false) || ($order->country ?? false))
                                            <p class="text-white-50 mb-2 fs-6" style="color: rgba(255,255,255,0.8) !important;">
                                                @if($order->city ?? false) {{ optional($order->city)->name ?? 'Unknown City' }}, @endif
                                                @if($order->country ?? false) {{ optional($order->country)->name ?? 'Unknown Country' }} @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items de la Orden con verificación null -->
                                @if(isset($order->items) && $order->items->count() > 0)
                                    <h6 class="text-white mb-3 fw-bold fs-5" style="color: white !important;">
                                        <i class="fas fa-list me-2 text-success"></i>Order Items ({{ $order->items->count() }})
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead style="background: rgba(255,255,255,0.1);">
                                                <tr>
                                                    <th class="text-white fw-bold fs-6" style="color: white !important;">Product</th>
                                                    <th class="text-center text-white fw-bold fs-6" style="color: white !important;">Quantity</th>
                                                    <th class="text-end text-white fw-bold fs-6" style="color: white !important;">Unit Price</th>
                                                    <th class="text-end text-white fw-bold fs-6" style="color: white !important;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                                    <td class="py-3">
                                                        <div class="d-flex align-items-center">
                                                            @if(($item->product ?? false) && optional($item->product)->images->first())
                                                                <img src="{{ Storage::url($item->product->images->first()->image) }}" 
                                                                     alt="{{ $item->product_name ?? 'Product' }}" 
                                                                     class="me-3 rounded shadow"
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="me-3 bg-secondary rounded d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-image text-white"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="text-white fw-semibold fs-6" style="color: white !important;">{{ $item->product_name ?? 'Unknown Product' }}</div>
                                                                @if($item->product ?? false)
                                                                    <small class="text-white-50" style="color: rgba(255,255,255,0.8) !important;">SKU: {{ $item->product->id ?? 'N/A' }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center py-3">
                                                        <span class="badge bg-success px-3 py-2 fs-6" style="color: white !important;">{{ $item->quantity ?? 0 }}</span>
                                                    </td>
                                                    <td class="text-end py-3 fs-6" style="color: white !important;">${{ number_format($item->product_price ?? 0, 2) }}</td>
                                                    <td class="text-end fw-bold py-3 fs-5" style="color: white !important;">${{ number_format($item->total_price ?? 0, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <!-- Resumen de Totales con verificación null -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="border-top border-light pt-4" style="border-opacity: 0.3 !important;">
                                            <div class="d-flex justify-content-between mb-2 fs-6">
                                                <span style="color: rgba(255,255,255,0.8) !important;">Subtotal:</span>
                                                <span style="color: white !important;">${{ number_format($order->subtotal ?? 0, 2) }}</span>
                                            </div>
                                            @if(($order->tax_amount ?? 0) > 0)
                                                <div class="d-flex justify-content-between mb-2 fs-6">
                                                    <span style="color: rgba(255,255,255,0.8) !important;">Tax:</span>
                                                    <span style="color: white !important;">${{ number_format($order->tax_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if(($order->shipping_amount ?? 0) > 0)
                                                <div class="d-flex justify-content-between mb-2 fs-6">
                                                    <span style="color: rgba(255,255,255,0.8) !important;">Shipping:</span>
                                                    <span style="color: white !important;">${{ number_format($order->shipping_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            <hr class="border-light" style="border-opacity: 0.5 !important;">
                                            <div class="d-flex justify-content-between fw-bold fs-4">
                                                <span style="color: white !important;">Total:</span>
                                                <span class="text-success">${{ number_format($order->total_amount ?? 0, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($order->notes ?? false)
                                    <div class="mt-4 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                        <h6 class="mb-2 fw-bold" style="color: white !important;">
                                            <i class="fas fa-sticky-note me-2 text-success"></i>Notes
                                        </h6>
                                        <p class="mb-0 fs-6" style="color: rgba(255,255,255,0.8) !important;">{{ $order->notes }}</p>
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

/* FORZAR TODOS LOS TEXTOS A SER VISIBLES */
.container, 
.container * {
    color: white !important;
}

/* Excepciones para badges y botones específicos */
.badge.bg-warning,
.badge.text-dark,
.btn.text-dark {
    color: #000 !important;
}

/* Texto específico para cards y elementos */
.card,
.card *,
.accordion,
.accordion * {
    color: white !important;
}

/* Forzar texto blanco en tablas */
.table,
.table *,
.table th,
.table td,
.table thead,
.table tbody {
    color: white !important;
    border-color: rgba(255,255,255,0.2) !important;
}

/* Texto muted debe ser visible */
.text-muted,
.text-secondary {
    color: rgba(255,255,255,0.7) !important;
}

/* Texto semi-transparente */
.text-white-50 {
    color: rgba(255,255,255,0.8) !important;
}

/* Headers y títulos */
h1, h2, h3, h4, h5, h6 {
    color: white !important;
}

/* Párrafos y spans */
p, span, div, small {
    color: white !important;
}

/* Links que no sean botones */
a:not(.btn) {
    color: #28a745 !important;
}

a:not(.btn):hover {
    color: #34ce57 !important;
}

/* Accordión específico */
.accordion .btn-link {
    text-decoration: none !important;
    transition: all 0.3s ease;
    color: white !important;
}

.accordion .btn-link:focus {
    box-shadow: none;
    color: white !important;
}

.accordion .btn-link:hover {
    opacity: 0.8;
    transform: scale(1.1);
    color: white !important;
}

.accordion .card-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.accordion .collapse.show {
    border-top: 1px solid rgba(255,255,255,0.1);
}

/* Forzar visibilidad en elementos form */
.form-control,
.form-select,
.form-label,
input,
select,
textarea {
    color: white !important;
    background-color: rgba(255,255,255,0.1) !important;
    border-color: rgba(255,255,255,0.3) !important;
}

/* Placeholder también debe ser visible */
::placeholder {
    color: rgba(255,255,255,0.6) !important;
}

/* Cards específicas */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
}

/* Badges con mejor contraste */
.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge.bg-success {
    background-color: #28a745 !important;
    color: white !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
    color: white !important;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
    color: white !important;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
    color: white !important;
}

/* Animaciones sutiles */
.accordion .collapse {
    transition: all 0.3s ease;
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

/* ESPECÍFICO PARA ELEMENTOS QUE PODRÍAN TENER TEXTO NEGRO */
.invalid-feedback,
.text-danger,
.alert,
.alert * {
    color: #ff6b6b !important;
}

.text-success {
    color: #28a745 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.text-warning {
    color: #ffc107 !important;
}

/* Asegurar que los elementos strong y bold se vean */
strong, b, .fw-bold, .fw-semibold {
    color: white !important;
    font-weight: bold !important;
}

/* Elementos de lista */
ul, ol, li {
    color: white !important;
}

/* Asegurar visibilidad en elementos específicos del recibo */
.order-details *,
.order-summary *,
.payment-info *,
.shipping-info * {
    color: white !important;
}
</style>

@endsection