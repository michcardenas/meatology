@extends('layouts.app_admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header del Usuario -->
            <div class="card bg-dark border-secondary mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-light mb-1">🛒 Welcome {{ $user->name }}</h2>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-bag fa-2x text-white mb-2"></i>
                            <h4 class="text-white">{{ $orders->count() }}</h4>
                            <p class="text-white mb-0">Total Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-success border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x text-white mb-2"></i>
                            <h4 class="text-white">{{ $orders->where('status', 'completed')->count() }}</h4>
                            <p class="text-white mb-0">Completed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-warning border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x text-white mb-2"></i>
                            <h4 class="text-white">{{ $orders->where('status', 'pending')->count() }}</h4>
                            <p class="text-white mb-0">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-info border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-dollar-sign fa-2x text-white mb-2"></i>
                            <h4 class="text-white">${{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</h4>
                            <p class="text-white mb-0">Total Spent</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-secondary">

            <h4 class="text-light mb-4">📦 Your Orders</h4>

            @if($orders->isEmpty())
                <div class="card bg-dark border-secondary">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-light">No orders yet</h5>
                        <p class="text-muted">You haven't made any orders yet. Start shopping now!</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            @else
                <div class="accordion" id="ordersAccordion">
                    @foreach($orders as $index => $order)
                    <div class="card bg-dark border-secondary mb-3">
                        <div class="card-header bg-secondary" id="heading{{ $index }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-link text-white text-decoration-none p-0 me-3" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $index }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $index }}">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div>
                                        <h6 class="mb-1 text-white">
                                            <i class="fas fa-receipt me-2"></i>
                                            Order #{{ $order->order_number }}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $order->created_at->format('M d, Y - g:i A') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }} fs-6 mb-1">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="text-white fw-bold">
                                        ${{ number_format($order->total_amount, 2, '.', ',') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="collapse{{ $index }}" 
                             class="collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" 
                             data-bs-parent="#ordersAccordion">
                            <div class="card-body">
                                <!-- Información de la Orden -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="text-light mb-2">
                                            <i class="fas fa-info-circle me-2"></i>Order Details
                                        </h6>
                                        <p class="text-muted mb-1">
                                            <strong>Payment Status:</strong> 
                                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                        @if($order->payment_method)
                                            <p class="text-muted mb-1">
                                                <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}
                                            </p>
                                        @endif
                                        @if($order->customer_phone)
                                            <p class="text-muted mb-1">
                                                <strong>Phone:</strong> {{ $order->customer_phone }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-light mb-2">
                                            <i class="fas fa-shipping-fast me-2"></i>Shipping Address
                                        </h6>
                                        <p class="text-muted mb-1">{{ $order->customer_address }}</p>
                                        @if($order->city || $order->country)
                                            <p class="text-muted mb-1">
                                                @if($order->city) {{ $order->city->name }}, @endif
                                                @if($order->country) {{ $order->country->name }} @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items de la Orden -->
                                @if($order->items->count() > 0)
                                    <h6 class="text-light mb-3">
                                        <i class="fas fa-list me-2"></i>Order Items ({{ $order->items->count() }})
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-dark table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-end">Unit Price</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product && $item->product->images->first())
                                                                <img src="{{ Storage::url($item->product->images->first()->image) }}" 
                                                                     alt="{{ $item->product_name }}" 
                                                                     class="me-2 rounded"
                                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <div class="me-2 bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="text-white">{{ $item->product_name }}</div>
                                                                @if($item->product)
                                                                    <small class="text-muted">SKU: {{ $item->product->id }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td class="text-end">${{ number_format($item->product_price, 2) }}</td>
                                                    <td class="text-end fw-bold">${{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <!-- Resumen de Totales -->
                                <div class="row mt-3">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="border-top border-secondary pt-3">
                                            <div class="d-flex justify-content-between text-muted">
                                                <span>Subtotal:</span>
                                                <span>${{ number_format($order->subtotal, 2) }}</span>
                                            </div>
                                            @if($order->tax_amount > 0)
                                                <div class="d-flex justify-content-between text-muted">
                                                    <span>Tax:</span>
                                                    <span>${{ number_format($order->tax_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($order->shipping_amount > 0)
                                                <div class="d-flex justify-content-between text-muted">
                                                    <span>Shipping:</span>
                                                    <span>${{ number_format($order->shipping_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            <hr class="border-secondary">
                                            <div class="d-flex justify-content-between text-white fw-bold fs-5">
                                                <span>Total:</span>
                                                <span>${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($order->notes)
                                    <div class="mt-3">
                                        <h6 class="text-light">
                                            <i class="fas fa-sticky-note me-2"></i>Notes
                                        </h6>
                                        <p class="text-muted">{{ $order->notes }}</p>
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
.accordion .btn-link {
    text-decoration: none !important;
}

.accordion .btn-link:focus {
    box-shadow: none;
}

.accordion .card-header {
    border-bottom: 1px solid #495057;
}

.accordion .collapse.show {
    border-top: 1px solid #495057;
}

.table-dark th,
.table-dark td {
    border-color: #495057;
}
</style>

@endsection