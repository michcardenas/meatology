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
                        <h2>Payment Successful!</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Thank you for your purchase!</h4>
                            <p>Your payment has been processed successfully. You will receive a confirmation email shortly.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-receipt"></i> Order Details</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Order Number:</strong> #{{ $order->order_number }}</li>
                                    <li><strong>Transaction ID:</strong> {{ $order->transaction_id }}</li>
                                    <li><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
                                    <li><strong>Payment Date:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'Just now' }}</li>
                                    <li><strong>Status:</strong> 
                                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><i class="fas fa-truck"></i> Shipping Information</h5>
                                <address>
                                    <strong>{{ $order->customer_name }}</strong><br>
                                    {{ $order->customer_address }}<br>
                                    {{ $order->city->name ?? '' }}, {{ $order->country->name }}<br>
                                    <strong>Phone:</strong> {{ $order->customer_phone }}<br>
                                    <strong>Email:</strong> {{ $order->customer_email }}
                                </address>
                            </div>
                        </div>

                        <hr>

                        <h5><i class="fas fa-shopping-cart"></i> Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>${{ number_format($item->product_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Subtotal:</th>
                                        <th>${{ number_format($order->subtotal, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Tax:</th>
                                        <th>${{ number_format($order->tax_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Shipping:</th>
                                        <th>${{ number_format($order->shipping_amount, 2) }}</th>
                                    </tr>
                                    <tr class="table-success">
                                        <th colspan="3">Total Paid:</th>
                                        <th>${{ number_format($order->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($order->notes)
                        <div class="mt-3">
                            <h6><i class="fas fa-sticky-note"></i> Order Notes:</h6>
                            <p class="text-muted">{{ $order->notes }}</p>
                        </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Continue Shopping
                            </a>
                            
                            @auth
                            <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-list"></i> View My Orders
                            </a>
                            @endauth
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6><i class="fas fa-info-circle"></i> What's Next?</h6>
                            <ul class="mb-0">
                                <li>You will receive an order confirmation email within the next few minutes</li>
                                <li>We will process your order and prepare it for shipping</li>
                                <li>You'll receive tracking information once your order ships</li>
                                <li>If you have any questions, please contact our support team</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>