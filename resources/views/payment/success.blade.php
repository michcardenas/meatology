@extends('layouts.app')

@section('title', 'Payment Successful - Order #' . $order->order_number)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .payment-success-card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
    }
    .success-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    .badge-payment {
        font-size: 0.875rem;
    }
    .info-section {
        background-color: #f8f9fa;
        border-left: 4px solid #28a745;
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
                    <h2 class="mb-0">¡Pago Exitoso!</h2>
                </div>
                
                <div class="card-body p-4">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">
                            <i class="fas fa-thumbs-up me-2"></i>¡Gracias por tu compra!
                        </h4>
                        <p class="mb-0">Tu pago ha sido procesado exitosamente. Recibirás un email de confirmación en breve.</p>
                    </div>

                    <!-- Información principal -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-receipt text-primary me-2"></i>Detalles de la Orden
                                    </h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>Número de Orden:</strong> 
                                            <span class="badge bg-dark ms-1">#{{ $order->order_number }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <strong>ID de Transacción:</strong>
                                            <small class="text-muted d-block">{{ $order->transaction_id }}</small>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Fecha de Orden:</strong> {{ $order->created_at->format('M d, Y H:i') }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Fecha de Pago:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'Recién procesado' }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Estado:</strong> 
                                            <span class="badge bg-success badge-payment">{{ ucfirst($order->status) }}</span>
                                        </li>
                                        <li class="mb-0">
                                            <strong>Método de Pago:</strong> 
                                            <span class="badge bg-primary badge-payment">
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
                                        <i class="fas fa-truck text-info me-2"></i>Información de Envío
                                    </h5>
                                    <address class="mb-0">
                                        <strong>{{ $order->customer_name }}</strong><br>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $order->customer_address }}<br>
                                        <i class="fas fa-phone text-muted me-1"></i><strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                                        <i class="fas fa-envelope text-muted me-1"></i><strong>Email:</strong> {{ $order->customer_email }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de pago -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>Resumen de Pago
                                    </h5>
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Impuestos:</td>
                                            <td class="text-end">${{ number_format($order->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Envío:</td>
                                            <td class="text-end">${{ number_format($order->shipping_amount, 2) }}</td>
                                        </tr>
                                        <tr class="table-success fw-bold">
                                            <td>Total Pagado:</td>
                                            <td class="text-end fs-5">${{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle text-warning me-2"></i>¿Qué sigue?
                                    </h5>
                                    <ul class="list-unstyled small mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Recibirás un email de confirmación en los próximos minutos
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-box text-primary me-2"></i>
                                            Procesaremos tu orden y la prepararemos para envío
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-shipping-fast text-info me-2"></i>
                                            Te enviaremos información de rastreo una vez que se envíe
                                        </li>
                                        <li class="mb-0">
                                            <i class="fas fa-headset text-secondary me-2"></i>
                                            Si tienes preguntas, contacta a nuestro equipo de soporte
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notas de la orden -->
                    @if($order->notes)
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-sticky-note text-warning me-2"></i>Notas de la Orden:
                                </h6>
                                <p class="card-text text-muted mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="text-center mb-4">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Continuar Comprando
                        </a>
                        
                        @auth
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-list me-2"></i>Ver Mis Órdenes
                        </a>
                        @endauth
                    </div>

                    <!-- Información de seguridad -->
                    <div class="info-section p-3 rounded text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt text-success me-2"></i> 
                            Tu pago fue procesado de forma segura por Square
                            <span class="d-block mt-1">
                                <i class="fas fa-lock me-1"></i>
                                Transacción encriptada SSL • Datos protegidos
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
// Opcional: Auto-scroll al top al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo(0, 0);
    
    // Opcional: Confetti effect (si quieres agregar un efecto especial)
    // console.log('Payment successful! 🎉');
});
</script>
@endpush