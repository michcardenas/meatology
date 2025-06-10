@extends('layouts.app_admin')

@section('content')
<div class="container py-4">
    <h2>🛒 Bienvenido {{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>

    <hr>
    <h4>📦 Tus Órdenes</h4>
    @if($orders->isEmpty())
        <div class="alert alert-info">Aún no tienes órdenes registradas.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th># Orden</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Pago</th>
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
