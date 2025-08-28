@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color: #011904; min-height: 100vh;">
    <div class="mb-4">
        <h2 class="text-white" style="color: white !important;">👑 Admin Panel</h2>
        <p class="text-white" style="color: rgba(255,255,255,0.8) !important;">
            From here you can manage products, categories, countries, cities, and orders.
        </p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: rgba(255,255,255,0.1);">
                    <h4 class="text-white mb-0" style="color: white !important;">
                        <i class="fas fa-box me-2"></i>Orders Management
                    </h4>
                </div>
                <div class="card-body">
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr style="border-bottom: 2px solid rgba(255,255,255,0.2);">
                                        <th class="text-white fw-bold" style="color: white !important;">Order #</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Customer</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Date</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Total</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Current Status</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Change Status</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                        <td class="text-white py-3" style="color: white !important;">
                                            <strong>#{{ $order->order_number }}</strong>
                                        </td>
                                        <td class="text-white py-3" style="color: white !important;">
                                            <div>
                                                <strong>{{ $order->customer_name ?? ($order->user ? $order->user->name : 'Guest') }}</strong>
                                                <br>
                                                <small class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                                    {{ $order->customer_email ?? ($order->user ? $order->user->email : '') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-white py-3" style="color: white !important;">
                                            {{ $order->created_at->format('M d, Y') }}
                                            <br>
                                            <small class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                                {{ $order->created_at->format('g:i A') }}
                                            </small>
                                        </td>
                                        <td class="text-white py-3" style="color: white !important;">
                                            <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                            <br>
                                            <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} px-2 py-1"
                                                  style="{{ $order->payment_status === 'paid' ? 'color: white !important;' : 'color: #000 !important;' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-white py-3" style="color: white !important;">
                                            <span class="badge fs-6 px-3 py-2
                                                {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-success' : 
                                                   ($order->status === 'pending' ? 'bg-warning text-dark' : 
                                                   ($order->status === 'processing' ? 'bg-info' :
                                                   ($order->status === 'shipped' ? 'bg-primary' : 'bg-secondary'))) }}"
                                                style="{{ $order->status === 'pending' ? 'color: #000 !important;' : 'color: white !important;' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <form action="{{ route('admin.orders.update-status', $order->id ?? 1) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" 
                                                        class="form-select form-select-sm" 
                                                        onchange="this.form.submit()"
                                                        style="background: rgba(255,255,255,0.2) !important; 
                                                               color: white !important; 
                                                               border: 1px solid rgba(255,255,255,0.3) !important;
                                                               min-width: 120px;">
                                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="py-3">
                                            <button class="btn btn-outline-info btn-sm me-1" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#details-{{ $order->id }}"
                                                    style="color: white !important; border-color: #17a2b8;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Fila de detalles colapsable -->
                                    <tr class="collapse" id="details-{{ $order->id }}">
                                        <td colspan="7" class="py-3" style="background: rgba(255,255,255,0.05);">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-white fw-bold" style="color: white !important;">
                                                        <i class="fas fa-shipping-fast me-2"></i>Shipping Info
                                                    </h6>
                                                    <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                        <strong>Address:</strong> {{ $order->customer_address ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                        <strong>Phone:</strong> {{ $order->customer_phone ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-white fw-bold" style="color: white !important;">
                                                        <i class="fas fa-list me-2"></i>Order Items
                                                    </h6>
                                                    @if(isset($order->items) && $order->items->count() > 0)
                                                        @foreach($order->items as $item)
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-white" style="color: rgba(255,255,255,0.9) !important;">
                                                                    {{ $item->quantity }}x {{ $item->product_name }}
                                                                </span>
                                                                <span class="text-white" style="color: white !important;">
                                                                    ${{ number_format($item->total_price, 2) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">No items found</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-white mb-3" style="color: rgba(255,255,255,0.5) !important;"></i>
                            <h5 class="text-white" style="color: white !important;">No orders found</h5>
                            <p class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                Orders will appear here when customers make purchases.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Forzar texto blanco en todo */
body {
    background-color: #011904 !important;
}

.container,
.container *,
.card,
.card *,
.table,
.table *,
h1, h2, h3, h4, h5, h6,
p, span, div, small, strong, b,
th, td {
    color: white !important;
}

/* Excepciones para badges con fondo claro */
.badge.bg-warning,
.badge.text-dark {
    color: #000 !important;
}

/* Select personalizado */
.form-select {
    background-color: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.3) !important;
    color: white !important;
}

.form-select option {
    background-color: #011904 !important;
    color: white !important;
}

.form-select:focus {
    border-color: rgba(255,255,255,0.5) !important;
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25) !important;
}

/* Hover effects */
.table tbody tr:hover {
    background-color: rgba(255,255,255,0.05) !important;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación al cambiar estado
    const statusSelects = document.querySelectorAll('select[name="status"]');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function(e) {
            const newStatus = this.value;
            const orderNumber = this.closest('tr').querySelector('strong').textContent;
            
            if (confirm(`Are you sure you want to change order ${orderNumber} status to "${newStatus.toUpperCase()}"?`)) {
                // El formulario se enviará automáticamente
                return true;
            } else {
                // Revertir al estado anterior
                e.preventDefault();
                const originalSelected = this.querySelector('[selected]');
                if (originalSelected) {
                    this.value = originalSelected.value;
                }
                return false;
            }
        });
    });
});
</script>

@endsection