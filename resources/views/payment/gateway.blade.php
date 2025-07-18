<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Order #{{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white text-center">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h2>¡Pago Exitoso!</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">¡Gracias por tu compra!</h4>
                            <p>Tu pago ha sido procesado exitosamente. Recibirás un email de confirmación en breve.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-receipt"></i> Detalles de la Orden</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Número de Orden:</strong> #{{ $order->order_number }}</li>
                                    <li><strong>ID de Transacción:</strong> {{ $order->transaction_id }}</li>
                                    <li><strong>Fecha de Orden:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
                                    <li><strong>Fecha de Pago:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'Recién procesado' }}</li>
                                    <li><strong>Estado:</strong> 
                                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                    </li>
                                    <li><strong>Método de Pago:</strong> 
                                        <span class="badge bg-primary">{{ ucfirst($order->payment_method ?? 'Square') }}</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><i class="fas fa-truck"></i> Información de Envío</h5>
                                <address>
                                    <strong>{{ $order->customer_name }}</strong><br>
                                    {{ $order->customer_address }}<br>
                                    <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                                    <strong>Email:</strong> {{ $order->customer_email }}
                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-money-bill-wave"></i> Resumen de Pago</h5>
                                <table class="table table-sm">
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
                                        <td class="text-end">${{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle"></i> ¿Qué sigue?</h5>
                                <ul class="small">
                                    <li>Recibirás un email de confirmación en los próximos minutos</li>
                                    <li>Procesaremos tu orden y la prepararemos para envío</li>
                                    <li>Te enviaremos información de rastreo una vez que se envíe</li>
                                    <li>Si tienes preguntas, contacta a nuestro equipo de soporte</li>
                                </ul>
                            </div>
                        </div>

                        @if($order->notes)
                        <hr>
                        <div class="mt-3">
                            <h6><i class="fas fa-sticky-note"></i> Notas de la Orden:</h6>
                            <p class="text-muted bg-light p-3 rounded">{{ $order->notes }}</p>
                        </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-bag"></i> Continuar Comprando
                            </a>
                            
                            @auth
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-list"></i> Ver Mis Órdenes
                            </a>
                            @endauth
                        </div>

                        <div class="mt-4 p-3 bg-light rounded text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt text-success"></i> 
                                Tu pago fue procesado de forma segura por Square
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>