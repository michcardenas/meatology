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
        border-left: 4px solid #011904;
    }
    .payment-form-card {
        border-left: 4px solid #011904;
    }
    #card-container {
        min-height: 60px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        margin-bottom: 10px;
    }
    .security-badges {
        background: linear-gradient(135deg, #011904 0%, #28a745 100%);
        color: white;
    }
    .total-amount {
        font-size: 1.5rem;
        font-weight: bold;
        color: #011904;
    }
    .btn-success {
        background-color: #011904;
        border-color: #011904;
    }
    .btn-success:hover {
        background-color: #023a07;
        border-color: #023a07;
    }
    .text-brand {
        color: #011904;
    }
    .bg-brand {
        background-color: #011904;
    }
    .card-title {
        color: #011904;
    }
    .order-header {
        color: #011904;
        font-weight: bold;
    }
    .loading-message {
        text-align: center;
        padding: 20px;
        color: #666;
    }
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 5px;
        margin: 10px 0;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Order Summary -->
        <div class="col-lg-4 mb-4">
            <div class="card payment-card order-summary-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="order-header">Order #{{ $order->order_number }}</h6>
                    <hr>
                    
                    @php
                        // Calcular ahorros de productos basado en los items de la orden
                        $totalSavings = 0;
                        $originalSubtotal = 0;

                        foreach($order->items as $item) {
                            if(isset($item->original_price) && $item->original_price > $item->product_price) {
                                $itemSavings = ($item->original_price - $item->product_price) * $item->quantity;
                                $totalSavings += $itemSavings;
                                $originalSubtotal += $item->original_price * $item->quantity;
                            } else {
                                $originalSubtotal += $item->product_price * $item->quantity;
                            }
                        }

                        // Si no hay datos en los items, usar datos de la orden
                        if($totalSavings == 0) {
                            $totalSavings = $order->product_savings ?? 0;
                            $originalSubtotal = $order->original_subtotal ?? ($order->subtotal + $totalSavings);
                        }
                    @endphp

                    @if($totalSavings > 0)
                        <div class="alert alert-success py-2 mb-3">
                            <small><i class="fas fa-tag"></i> <strong>You saved: ${{ number_format($totalSavings, 2) }}</strong></small>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-muted text-decoration-line-through">
                            <span>Original subtotal:</span>
                            <span>${{ number_format($originalSubtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Product savings:</span>
                            <span>-${{ number_format($totalSavings, 2) }}</span>
                        </div>
                        <hr class="my-2">
                    @endif
                    
                    @php
                        // Calcular subtotal correcto
                        $correctSubtotal = $order->total_amount - $order->tax_amount - $order->shipping_amount;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($correctSubtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>${{ number_format($order->shipping_amount, 2) }}</span>
                    </div>

                    {{-- Mostrar descuento adicional si existe --}}
                    @if($order->discount_amount && $order->discount_amount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Additional Discount @if($order->discount_code)({{ $order->discount_code }})@endif:</span>
                            <span>-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif

                    {{-- Mostrar propina si existe --}}
                    @if($order->tip_amount && $order->tip_amount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tip @if($order->tip_percentage)({{ $order->tip_percentage }}%)@endif:</span>
                            <span>${{ number_format($order->tip_amount, 2) }}</span>
                        </div>
                    @endif

                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total to Pay:</span>
                        <span class="total-amount">${{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    {{-- Mostrar resumen de ahorros totales --}}
                    @php
                        $totalAllSavings = $totalSavings + ($order->discount_amount ?? 0);
                    @endphp
                    @if($totalAllSavings > 0)
                        <div class="alert alert-info py-2 text-center">
                            <small><strong>🎯 Total Savings: ${{ number_format($totalAllSavings, 2) }}</strong></small>
                        </div>
                    @endif

                    <hr>
                    <h6 class="text-info">
                        <i class="fas fa-shipping-fast me-2"></i>Shipping Address:
                    </h6>
                    <address class="small text-muted mb-0">
                        <strong>{{ $order->customer_name }}</strong><br>
                        {{ $order->customer_address }}<br>
                        {{ $order->city->name ?? '' }}, {{ $order->country->name }}<br>
                        {{ $order->customer_phone }}
                    </address>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-lg-8">
            <div class="card payment-card payment-form-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Payment Information
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
                                    <h6 class="text-brand mb-2">
                                        <i class="fas fa-dollar-sign me-2"></i>Amount to Pay:
                                    </h6>
                                    <div class="total-amount">${{ number_format($order->total_amount, 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-brand text-white rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-info-circle me-2"></i>Information:
                                    </h6>
                                    <small>Secure payment processed by Square</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-credit-card me-2"></i>Card Information
                            </label>
                            
                            <!-- Loading message -->
                            <div id="loading-message" class="loading-message">
                                <i class="fas fa-spinner fa-spin"></i> Loading payment form...
                            </div>
                            
                            <!-- Error message container -->
                            <div id="error-message" class="error-message" style="display: none;"></div>
                            
                            <!-- Square payment form container -->
                            <div id="card-container" style="display: none;"></div>
                            
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-lock me-1"></i>
                                Your data is protected with SSL encryption
                            </small>
                        </div>

                        <input type="hidden" id="source-id" name="source_id">
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-success btn-lg" id="payment-button" disabled>
                                <i class="fas fa-lock me-2"></i>
                                Complete Payment - ${{ number_format($order->total_amount, 2) }}
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Shop
                            </a>
                        </div>
                    </form>

                    <!-- Security Badges -->
                    <div class="security-badges p-3 rounded mt-4 text-center">
                        <div class="row">
                            <div class="col-4">
                                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                                <div class="small">Secure Payment</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-lock fa-2x mb-2"></i>
                                <div class="small">SSL Encrypted</div>
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

<!-- Square.js Script -->
<script src="https://web.squarecdn.com/v1/square.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    console.log('Initializing Square payment form...');
    
    const loadingMessage = document.getElementById('loading-message');
    const errorMessage = document.getElementById('error-message');
    const cardContainer = document.getElementById('card-container');
    const paymentButton = document.getElementById('payment-button');
    
    // Show error function
    function showError(message) {
        console.error('Square Error:', message);
        loadingMessage.style.display = 'none';
        errorMessage.style.display = 'block';
        errorMessage.innerHTML = `
            <strong>Payment form error:</strong> ${message}<br>
            <small>Please refresh the page or contact support if the problem persists.</small>
        `;
    }
    
    // Check if Square.js loaded
    if (!window.Square) {
        showError('Square.js failed to load. Please check your internet connection and refresh the page.');
        return;
    }
    
    console.log('Square.js loaded successfully');
    console.log('Application ID:', '{{ config("square.application_id") }}');
    console.log('Location ID:', '{{ config("square.location_id") }}');
    
    try {
        // Initialize Square Payments
        const payments = window.Square.payments('{{ config("square.application_id") }}', '{{ config("square.location_id") }}');
        
        // Initialize card
        const card = await payments.card({
            style: {
                '.input-container': {
                    borderRadius: '6px',
                    borderColor: '#d1d5db'
                },
                '.input-container.is-focus': {
                    borderColor: '#011904'
                },
                '.input-container.is-error': {
                    borderColor: '#ef4444'
                },
                '.message-text': {
                    color: '#ef4444'
                }
            }
        });
        
        // Attach card to container
        await card.attach('#card-container');
        
        // Show form and hide loading
        loadingMessage.style.display = 'none';
        cardContainer.style.display = 'block';
        paymentButton.disabled = false;
        
        console.log('Square card form initialized successfully');
        
        // Handle form submission
        document.getElementById('payment-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            
            const button = document.getElementById('payment-button');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...';
            
            try {
                console.log('Starting payment tokenization...');
                const result = await card.tokenize();
                console.log('Tokenization result:', result);
                
                if (result.status === 'OK') {
                    console.log('Token generated successfully:', result.token);
                    document.getElementById('source-id').value = result.token;
                    console.log('Submitting form with token...');
                    this.submit();
                } else {
                    console.error('Tokenization failed:', result);
                    let errorMsg = 'Error processing card information.';
                    
                    if (result.errors && result.errors.length > 0) {
                        const firstError = result.errors[0];
                        errorMsg = firstError.detail || firstError.message || errorMsg;
                    }
                    
                    alert(errorMsg + ' Please check your card details and try again.');
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            } catch (error) {
                console.error('Payment processing error:', error);
                alert('Payment processing failed: ' + error.message + '. Please try again.');
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
        
    } catch (error) {
        console.error('Error initializing Square payments:', error);
        showError('Failed to initialize payment form: ' + error.message);
    }
});
</script>
@endsection