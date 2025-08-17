@extends('layouts.app')

@section('title', 'Payment Successful - Order #' . $order->order_number)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* 🔥 MEJORADO PARA FONDO VERDE OSCURO */
    body {
        background-color: #013105 !important;
        color: #ffffff !important;
    }
    
    .payment-success-card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        border: 2px solid #28a745 !important;
        background-color: #1a1a1a !important;
        color: #ffffff !important;
    }
    
    .success-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: #ffffff !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .success-header h2 {
        color: #ffffff !important;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .badge-payment {
        font-size: 0.875rem;
    }
    
    .info-section {
        background-color: rgba(40, 167, 69, 0.1) !important;
        border-left: 4px solid #28a745;
        color: #ffffff !important;
    }
    
    .card {
        background-color: #2d2d2d !important;
        border: 1px solid #444 !important;
        color: #ffffff !important;
    }
    
    .card-title {
        color: #28a745 !important;
        font-weight: bold;
    }
    
    .card-body {
        color: #ffffff !important;
    }
    
    .btn-primary {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: #ffffff !important;
    }
    
    .btn-primary:hover {
        background-color: #20c997 !important;
        border-color: #20c997 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .btn-outline-secondary {
        border-color: #ffffff !important;
        color: #ffffff !important;
    }
    
    .btn-outline-secondary:hover {
        background-color: #ffffff !important;
        color: #013105 !important;
    }
    
    .text-brand {
        color: #28a745 !important;
    }
    
    .border-brand {
        border-color: #28a745 !important;
    }
    
    .bg-brand {
        background-color: #28a745 !important;
        color: #ffffff !important;
    }
    
    .table-success {
        background-color: rgba(40, 167, 69, 0.2) !important;
        color: #ffffff !important;
    }
    
    .table {
        color: #ffffff !important;
    }
    
    .table td {
        color: #ffffff !important;
        border-color: #444 !important;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.2) !important;
        border-color: #28a745 !important;
        color: #ffffff !important;
    }
    
    .alert-heading {
        color: #ffffff !important;
    }
    
    .text-muted {
        color: #cccccc !important;
    }
    
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    
    /* Animación de éxito */
    .success-header i {
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    
    /* Efectos hover para las tarjetas */
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.2);
        transition: all 0.3s ease;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card payment-success-card border-success">
                <div class="card-header success-header text-white text-center py-4">
                    <i class="fas fa-check-circle fa-4x mb-3"></i>
                    <h2 class="mb-0">🎉 Payment Successful! 🎉</h2>
                    <p class="mb-0 mt-2">Your order has been confirmed</p>
                </div>
                
                <div class="card-body p-4">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">
                            <i class="fas fa-thumbs-up me-2"></i>Thank you for your purchase!
                        </h4>
                        <p class="mb-0">Your payment has been processed successfully. You will receive a confirmation email shortly.</p>
                    </div>

                    <!-- Main Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-receipt text-brand me-2"></i>Order Details
                                    </h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>Order Number:</strong> 
                                            <span class="badge bg-brand ms-1">#{{ $order->order_number }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Transaction ID:</strong>
                                            <small class="text-muted d-block">{{ $order->transaction_id }}</small>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Payment Date:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'Just now' }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Status:</strong> 
                                            <span class="badge bg-success badge-payment">{{ ucfirst($order->status) }}</span>
                                        </li>
                                        <li class="mb-0">
                                            <strong>Payment Method:</strong> 
                                            <span class="badge bg-brand badge-payment">
                                                <i class="fas fa-credit-card me-1"></i>{{ ucfirst($order->payment_method ?? 'Square') }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-truck text-info me-2"></i>Shipping Information
                                    </h5>
                                    <address class="mb-0">
                                        <strong>{{ $order->customer_name }}</strong><br>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $order->customer_address }}<br>
                                        <i class="fas fa-phone text-muted me-1"></i><strong>Phone:</strong> {{ $order->customer_phone }}<br>
                                        <i class="fas fa-envelope text-muted me-1"></i><strong>Email:</strong> {{ $order->customer_email }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>Payment Summary
                                    </h5>
                                    
                                    @php
                                        // 🔥 CALCULAR SUBTOTAL CORRECTO
                                        $correctSubtotal = $order->total_amount - $order->tax_amount - $order->shipping_amount;
                                        
                                        // 🚨 DEBUG: Para ver los valores
                                        \Log::info('Payment Success Order Debug:', [
                                            'order_id' => $order->id,
                                            'total_amount' => $order->total_amount,
                                            'tax_amount' => $order->tax_amount,
                                            'shipping_amount' => $order->shipping_amount,
                                            'subtotal_db' => $order->subtotal,
                                            'calculated_subtotal' => $correctSubtotal
                                        ]);
                                    @endphp
                                    
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="text-end">${{ number_format($correctSubtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax:</td>
                                            <td class="text-end">${{ number_format($order->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping:</td>
                                            <td class="text-end">${{ number_format($order->shipping_amount, 2) }}</td>
                                        </tr>
                                        <tr class="table-success fw-bold">
                                            <td>Total Paid:</td>
                                            <td class="text-end fs-5">${{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                    
                                    {{-- 🚨 MOSTRAR ADVERTENCIA SI HAY DISCREPANCIA --}}
                                    @if(abs($order->subtotal - $correctSubtotal) > 0.01)
                                        <div class="alert alert-warning mt-2">
                                            <small><i class="fas fa-exclamation-triangle"></i> Subtotal recalculated for accuracy</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle text-warning me-2"></i>What's Next?
                                    </h5>
                                    <ul class="list-unstyled small mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            You will receive a confirmation email within the next few minutes
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-box text-brand me-2"></i>
                                            We will process your order and prepare it for shipping
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-shipping-fast text-info me-2"></i>
                                            You'll receive tracking information once your order ships
                                        </li>
                                        <li class="mb-0">
                                            <i class="fas fa-headset text-secondary me-2"></i>
                                            If you have any questions, please contact our support team
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    @if($order->notes)
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-sticky-note text-warning me-2"></i>Order Notes:
                                </h6>
                                <p class="card-text text-muted mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="text-center mb-4">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        
                        @auth
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-list me-2"></i>View My Orders
                        </a>
                        @endauth
                    </div>

                    <!-- Security Information -->
                    <div class="info-section p-3 rounded text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt text-success me-2"></i> 
                            Your payment was securely processed by Square
                            <span class="d-block mt-1">
                                <i class="fas fa-lock me-1"></i>
                                SSL Encrypted Transaction • Protected Data
                            </span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-scroll to top when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo(0, 0);
    
    // 🎉 EFECTO DE CONFETTI (opcional)
    console.log('🎉 Payment successful! 🎉');
    
    // Opcional: Agregar efecto de sonido de éxito
    // const audio = new Audio('/sounds/success.mp3');
    // audio.play().catch(e => console.log('Audio not available'));
});
</script>
@endpush