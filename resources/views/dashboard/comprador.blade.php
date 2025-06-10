@extends('layouts.app_admin')

@section('content')
<div class="container py-4">
    <h2>🛒 Welcome {{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>

    <hr>
    <h4>📦 Your Orders</h4>
    @if($orders->isEmpty())
        <div class="alert alert-info">You don’t have any registered orders yet.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th># Order</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>${{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
