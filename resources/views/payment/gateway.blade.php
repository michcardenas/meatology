<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway - Order #{{ $order->order_number }}</title>
    <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <!-- Resumen de la orden -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-receipt"></i> Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <h6>Order #{{ $order->order_number }}</h6>
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <span>Tax:</span>
                            <span>${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <span>Shipping:</span>
                            <span>${{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        
                        <hr>
                        <h6>Shipping Address:</h6>
                        <small class="text-muted">
                            {{ $order->customer_name }}<br>
                            {{ $order->customer_address }}<br>
                            {{ $order->city->name ?? '' }}, {{ $order->country->name }}<br>
                            {{ $order->customer_phone }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Formulario de pago -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-credit-card"></i> Payment Information</h5>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            </div>
                        @endif

                        <form id="payment-form" action="{{ route('payment.process', $order) }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="payment-summary">
                                        <h6>Amount to Pay:</h6>
                                        <h3 class="text-success">${{ number_format($order->total_amount, 2) }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Card Information</label>
                                <div id="card-container" style="min-height: 100px;"></div>
                            </div>

                            <input type="hidden" id="source-id" name="source_id">
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" id="payment-button">
                                    <i class="fas fa-lock"></i> Complete Payment (${{ number_format($order->total_amount, 2) }})
                                </button>
                                
                                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Shop
                                </a>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt"></i> Your payment is secured by Square
                            </small>
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
                        borderRadius: '6px',
                        borderColor: '#d1d5db'
                    },
                    '.input-container.is-focus': {
                        borderColor: '#3b82f6'
                    },
                    '.input-container.is-error': {
                        borderColor: '#ef4444'
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
                document.getElementById('card-container').innerHTML = '<div class="alert alert-danger">Failed to load payment form. Please refresh the page.</div>';
                return;
            }

            // Handle payment form submission
            document.getElementById('payment-form').addEventListener('submit', async function (e) {
                e.preventDefault();

                const button = document.getElementById('payment-button');
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

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
                        let errorMsg = 'Error processing card information.';
                        if (result.errors && result.errors.length > 0) {
                            errorMsg += ' ' + result.errors[0].message;
                        }
                        alert(errorMsg + ' Please check your details and try again.');
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                } catch (e) {
                    console.error('Payment failed', e);
                    alert('Payment processing failed. Please try again. Error: ' + e.message);
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            });
        });
    </script>
</body>
</html>