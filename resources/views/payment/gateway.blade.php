@extends('layouts.app')

@section('title', 'Payment Gateway - Order #' . $order->order_number)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .payment-card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
    }
    .order-summary-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #007bff;
    }
    .payment-form-card {
        border-left: 4px solid #28a745;
    }
    #card-container {
        min-height: 80px;
        padding: 12px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    #card-container:focus-within {
        border-color: #007bff;
        background-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .security-badges {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    .total-amount {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Resumen de la orden -->
        <div class="col-lg-4 mb-4">
            <div class="card payment-card order-summary-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Resumen de Orden
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="text-primary">Order #{{ $order->order_number }}</h6>
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Impuestos:</span>
                        <span>${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Envío:</span>
                        <span>${{ number_format($order->shipping_amount, 2) }}</span>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total a Pagar:</span>
                        <span class="total-amount">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    
                    <hr>
                    <h6 class="text-info">
                        <i class="fas fa-shipping-fast me-2"></i>Dirección de Envío:
                    </h6>
                    <address class="small text-muted mb-0">
                        <strong>{{ $order->customer_name }}</strong><br>
                        {{ $order->customer_address }}<br>
                        {{ $order->customer_phone }}
                    </address>
                </div>
            </div>
        </div>

        <!-- Formulario de pago -->
        <div class="col-lg-8">
            <div class="card payment-card payment-form-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Información de Pago
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="payment-form" action="{{ route('payment.process', $order) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="text-success mb-2">
                                        <i class="fas fa-dollar-sign me-2"></i>Monto a Pagar:
                                    </h6>
                                    <div class="total-amount">${{ number_format($order->total_amount, 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-primary text-white rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-info-circle me-2"></i>Información:
                                    </h6>
                                    <small>Pago seguro procesado por Square</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-credit-card me-2"></i>Información de la Tarjeta
                            </label>
                            <div id="card-container"></div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-lock me-1"></i>
                                Tus datos están protegidos con encriptación SSL
                            </small>
                        </div>

                        <input type="hidden" id="source-id" name="source_id">
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-success btn-lg" id="payment-button">
                                <i class="fas fa-lock me-2"></i>
                                Completar Pago - ${{ number_format($order->total_amount, 2) }}
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver a la Tienda
                            </a>
                        </div>
                    </form>

                    <!-- Badges de seguridad -->
                    <div class="security-badges p-3 rounded mt-4 text-center">
                        <div class="row">
                            <div class="col-4">
                                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                                <div class="small">Pago Seguro</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-lock fa-2x mb-2"></i>
                                <div class="small">SSL Encriptado</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-certificate fa-2x mb-2"></i>
                                <div class="small">Square Verified</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function initializeCard(payments) {
    const card = await payments.card({
        style: {
            '.input-container': {
                borderRadius: '8px',
                borderColor: '#dee2e6',
                backgroundColor: '#ffffff'
            },
            '.input-container.is-focus': {
                borderColor: '#007bff'
            },
            '.input-container.is-error': {
                borderColor: '#dc3545'
            }
        }
    });
    await card.attach('#card-container');
    return card;
}

document.addEventListener('DOMContentLoaded', async function () {
    // Debug: Verificar que las credenciales estén llegando
    console.log('Application ID:', '{{ config("square.application_id") }}');
    console.log('Location ID:', '{{ config("square.location_id") }}');
    
    if (!window.Square) {
        throw new Error('Square.js failed to load properly');
    }

    const payments = window.Square.payments('{{ config("square.application_id") }}', '{{ config("square.location_id") }}');
    
    let card;
    try {
        card = await initializeCard(payments);
    } catch (e) {
        console.error('Initializing Card failed', e);
        document.getElementById('card-container').innerHTML = '<div class="alert alert-danger">Error al cargar el formulario de pago. Por favor, recarga la página.</div>';
        return;
    }

    // Handle payment form submission
    document.getElementById('payment-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const button = document.getElementById('payment-button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';

        try {
            console.log('Starting tokenization...');
            const result = await card.tokenize();
            console.log('Tokenization result:', result);
            
            if (result.status === 'OK') {
                console.log('Token generated:', result.token);
                document.getElementById('source-id').value = result.token;
                console.log('Form submitting with token...');
                e.target.submit();
            } else {
                console.error('Tokenization failed', result);
                let errorMsg = 'Error al procesar la información de la tarjeta.';
                if (result.errors && result.errors.length > 0) {
                    errorMsg += ' ' + result.errors[0].message;
                }
                alert(errorMsg + ' Por favor, verifica los datos y intenta nuevamente.');
                button.disabled = false;
                button.innerHTML = originalText;
            }
        } catch (e) {
            console.error('Payment failed', e);
            alert('Error en el procesamiento del pago. Por favor, intenta nuevamente. Error: ' + e.message);
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });
});
</script>
@endsection