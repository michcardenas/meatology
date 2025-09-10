@extends('layouts.app_admin') 

@section('content') 
<div class="container py-4" style="background-color: #011904; min-height: 100vh;"> 
    <div class="mb-4"> 
        <h2 class="text-white" style="color: white !important;">👑 Admin Panel</h2> 
        <p class="text-white" style="color: rgba(255,255,255,0.8) !important;"> 
            From here you can manage products, categories, countries, cities, orders, and users. 
        </p> 
    </div> 

    <!-- NUEVA SECCIÓN: Botones de Usuarios y Suscripciones -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(135deg, #28a745, #20c997); border-radius: 15px;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-envelope fa-3x text-white mb-3"></i>
                    <h5 class="text-white fw-bold mb-2">Newsletter Subscribers</h5>
                    <p class="text-white mb-3" style="opacity: 0.9;">View and manage all newsletter subscriptions</p>
                    <a href="{{ route('admin.subscriptions') }}" class="btn  btn-lg px-4">
                        <i class="fas fa-users me-2"></i>
                        View Subscribers
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 15px;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-user-cog fa-3x text-white mb-3"></i>
                    <h5 class="text-white fw-bold mb-2">All Users</h5>
                    <p class="text-white mb-3" style="opacity: 0.9;">Manage all registered users and accounts</p>
                    <a href="{{ route('admin.users') }}" class="btn  btn-lg px-4">
                        <i class="fas fa-list me-2"></i>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- NUEVA SECCIÓN: Botón de SEO -->
<div class="col-md-6 mb-3">
  <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(135deg, #fd7e14, #e83e8c); border-radius: 15px;">
    <div class="card-body text-center py-4">
      <i class="fas fa-search fa-3x text-white mb-3"></i>
      <h5 class="text-white fw-bold mb-2">Pages SEO</h5>
      <p class="text-white mb-3" style="opacity: 0.9;">Manage SEO settings per page</p>
      <a href="{{ route('admin.seo.pages') }}" class="btn  btn-lg px-4">
        <i class="fas fa-wrench me-2"></i>
        Open SEO
      </a>
    </div>
  </div>
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
                                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} px-2 py-1" style="{{ $order->payment_status === 'paid' ? 'color: white !important;' : 'color: #000 !important;' }}"> 
                                                    {{ ucfirst($order->payment_status) }} 
                                                </span> 
                                            </td> 
                                            <td class="text-white py-3" style="color: white !important;"> 
                                                <span class="badge fs-6 px-3 py-2 {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning text-dark' : ($order->status === 'processing' ? 'bg-info' : ($order->status === 'shipped' ? 'bg-primary' : 'bg-secondary'))) }}" style="{{ $order->status === 'pending' ? 'color: #000 !important;' : 'color: white !important;' }}"> 
                                                    {{ ucfirst($order->status) }} 
                                                </span> 
                                            </td> 
                                            <td class="py-3"> 
                                                <form action="{{ route('admin.orders.update-status', $order->id ?? 1) }}" method="POST" style="display: inline;"> 
                                                    @csrf 
                                                    @method('PATCH') 
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="background: rgba(255,255,255,0.2) !important; color: white !important; border: 1px solid rgba(255,255,255,0.3) !important; min-width: 120px;"> 
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
                                                <button class="btn btn-outline-info btn-sm me-1" data-bs-toggle="collapse" data-bs-target="#details-{{ $order->id }}" style="color: white !important; border-color: #17a2b8;"> 
                                                    <i class="fas fa-eye"></i> 
                                                </button> 
                                            </td> 
                                        </tr> 
                                        
                                        <!-- SECCIÓN MEJORADA: Fila de detalles colapsable con información completa -->
                                        <tr class="collapse" id="details-{{ $order->id }}">
                                            <td colspan="7" class="py-4" style="background: rgba(255,255,255,0.05);">
                                                <div class="row">
                                                    <!-- Columna izquierda: Información del cliente y envío -->
                                                    <div class="col-md-4">
                                                        <h6 class="text-white fw-bold mb-3" style="color: white !important;">
                                                            <i class="fas fa-user me-2"></i>Customer Details
                                                        </h6>
                                                        <div class="mb-3">
                                                            <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                <strong>Name:</strong> {{ $order->customer_name ?? ($order->user ? $order->user->name : 'Guest') }}
                                                            </p>
                                                            <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                <strong>Email:</strong> {{ $order->customer_email ?? ($order->user ? $order->user->email : 'N/A') }}
                                                            </p>
                                                            <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                <strong>Phone:</strong> {{ $order->customer_phone ?? 'N/A' }}
                                                            </p>
                                                        </div>

                                                        <h6 class="text-white fw-bold mb-3" style="color: white !important;">
                                                            <i class="fas fa-shipping-fast me-2"></i>Shipping Info
                                                        </h6>
                                                        <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                            <strong>Address:</strong><br>
                                                            {{ $order->customer_address ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                            <strong>Location:</strong> 
                                                            {{ $order->city ? $order->city->name : 'N/A' }}, 
                                                            {{ $order->country ? $order->country->name : 'N/A' }}
                                                        </p>
                                                        @if($order->notes)
                                                            <p class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                <strong>Special Notes:</strong><br>
                                                                <em>{{ $order->notes }}</em>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <!-- Columna central: Items del pedido -->
                                                    <div class="col-md-4">
                                                        <h6 class="text-white fw-bold mb-3" style="color: white !important;">
                                                            <i class="fas fa-list me-2"></i>Order Items
                                                        </h6>
                                                        @if(isset($order->items) && $order->items->count() > 0)
                                                            <div class="order-items-detail">
                                                                @foreach($order->items as $item)
                                                                    <div class="item-detail mb-3 p-2" style="background: rgba(255,255,255,0.05); border-radius: 8px;">
                                                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                                                            <span class="text-white fw-bold" style="color: white !important;">
                                                                                {{ $item->product_name }}
                                                                            </span>
                                                                            <span class="text-white fw-bold" style="color: white !important;">
                                                                                ${{ number_format($item->total_price, 2) }}
                                                                            </span>
                                                                        </div>
                                                                        <div class="small text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                                                            <div>Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</div>
                                                                            @if($item->product)
                                                                                <div>Category: {{ $item->product->category->name ?? 'N/A' }}</div>
                                                                                @if($item->product->descuento > 0)
                                                                                    <div class="text-success">
                                                                                        <i class="fas fa-tag me-1"></i>Product Discount: {{ $item->product->descuento }}% OFF
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <p class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">No items found</p>
                                                        @endif
                                                    </div>

                                                    <!-- Columna derecha: Resumen financiero -->
                                                    <div class="col-md-4">
                                                        <h6 class="text-white fw-bold mb-3" style="color: white !important;">
                                                            <i class="fas fa-calculator me-2"></i>Financial Summary
                                                        </h6>
                                                        <div class="financial-breakdown p-3" style="background: rgba(255,255,255,0.05); border-radius: 8px;">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-white" style="color: rgba(255,255,255,0.9) !important;">Subtotal:</span>
                                                                <span class="text-white fw-bold" style="color: white !important;">
                                                                    ${{ number_format($order->subtotal ?? 0, 2) }}
                                                                </span>
                                                            </div>
                                                            
                                                            @if($order->tax_amount > 0)
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span class="text-white" style="color: rgba(255,255,255,0.9) !important;">
                                                                        Tax {{ $order->city && $order->city->tax ? '('.$order->city->tax.'%)' : '' }}:
                                                                    </span>
                                                                    <span class="text-white fw-bold" style="color: white !important;">
                                                                        ${{ number_format($order->tax_amount, 2) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            
                                                            @if($order->shipping_amount > 0)
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span class="text-white" style="color: rgba(255,255,255,0.9) !important;">Shipping:</span>
                                                                    <span class="text-white fw-bold" style="color: white !important;">
                                                                        ${{ number_format($order->shipping_amount, 2) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- Verificar si hay tip en las notas o si agregaste campo tip_amount -->
                                                            @php
                                                                $tipAmount = 0;
                                                                // Si tienes campo tip_amount en la orden, úsalo:
                                                                // $tipAmount = $order->tip_amount ?? 0;
                                                                
                                                                // O si está en las notas, podrías parsearlo
                                                                if($order->notes && strpos(strtolower($order->notes), 'tip') !== false) {
                                                                    preg_match('/tip[:\s]*\$?(\d+\.?\d*)/', strtolower($order->notes), $matches);
                                                                    if(isset($matches[1])) {
                                                                        $tipAmount = floatval($matches[1]);
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            @if($tipAmount > 0)
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span class="text-white" style="color: rgba(255,255,255,0.9) !important;">Tip:</span>
                                                                    <span class="text-white fw-bold text-success" style="color: #28a745 !important;">
                                                                        ${{ number_format($tipAmount, 2) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            
                                                            <hr style="border-color: rgba(255,255,255,0.3);">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-white fw-bold" style="color: white !important;">TOTAL:</span>
                                                                <span class="text-white fw-bold fs-5" style="color: white !important;">
                                                                    ${{ number_format($order->total_amount, 2) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Información de pago -->
                                                        <div class="mt-3">
                                                            <h6 class="text-white fw-bold mb-2" style="color: white !important;">
                                                                <i class="fas fa-credit-card me-2"></i>Payment Info
                                                            </h6>
                                                            <div class="payment-info small">
                                                                <div class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                    <strong>Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}
                                                                </div>
                                                                @if($order->payment_transaction_id)
                                                                    <div class="text-white mb-1" style="color: rgba(255,255,255,0.9) !important;">
                                                                        <strong>Transaction ID:</strong> 
                                                                        <code style="color: #ffc107;">{{ $order->payment_transaction_id }}</code>
                                                                    </div>
                                                                @endif
                                                                <div class="text-white" style="color: rgba(255,255,255,0.9) !important;">
                                                                    <strong>Status:</strong>
                                                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} ms-1">
                                                                        {{ ucfirst($order->payment_status) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Fila adicional para información de fecha y seguimiento -->
                                                <div class="row mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                                                    <div class="col-md-6">
                                                        <h6 class="text-white fw-bold mb-2" style="color: white !important;">
                                                            <i class="fas fa-clock me-2"></i>Timeline
                                                        </h6>
                                                        <div class="small text-white" style="color: rgba(255,255,255,0.9) !important;">
                                                            <div><strong>Order placed:</strong> {{ $order->created_at->format('M d, Y g:i A') }}</div>
                                                            <div><strong>Last updated:</strong> {{ $order->updated_at->format('M d, Y g:i A') }}</div>
                                                            @if($order->created_at->diffInHours(now()) < 24)
                                                                <div class="text-info mt-1">
                                                                    <i class="fas fa-info-circle me-1"></i>Recent order ({{ $order->created_at->diffForHumans() }})
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-white fw-bold mb-2" style="color: white !important;">
                                                            <i class="fas fa-info-circle me-2"></i>Additional Info
                                                        </h6>
                                                        <div class="small text-white" style="color: rgba(255,255,255,0.9) !important;">
                                                            <div><strong>Order Type:</strong> {{ $order->isGuestOrder() ? 'Guest Order' : 'Registered User' }}</div>
                                                            <div><strong>Items Count:</strong> {{ $order->items->count() }} items</div>
                                                            <div><strong>Total Quantity:</strong> {{ $order->items->sum('quantity') }} units</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- FIN SECCIÓN MEJORADA -->
                                        
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

/* Estilos adicionales para los detalles mejorados */
.order-items-detail .item-detail {
    transition: background-color 0.2s ease;
}

.order-items-detail .item-detail:hover {
    background-color: rgba(255,255,255,0.08) !important;
}

.financial-breakdown {
    transition: background-color 0.2s ease;
}

.financial-breakdown:hover {
    background-color: rgba(255,255,255,0.08) !important;
}

code {
    background-color: rgba(255,255,255,0.1) !important;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.9em;
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
    }
    
    .order-items-detail .item-detail {
        margin-bottom: 15px;
    }
    
    .financial-breakdown {
        font-size: 0.9rem;
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