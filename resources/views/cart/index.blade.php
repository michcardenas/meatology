@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">🛒 Mi carrito</h1>

  @if (Cart::count() > 0)
    <table class="table align-middle">
      <thead class="table-light">
        <tr>
          <th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach (Cart::content() as $row)
          <tr>
            <td>
              <img src="{{ asset($row->options->image ?? 'images/placeholder.jpg') }}"
                   width="60" class="me-2">
              {{ $row->name }}
            </td>
            <td>${{ number_format($row->price, 0) }}</td>
            <td>
              <form action="{{ route('cart.update', $row->rowId) }}" method="POST" class="d-flex">
                @csrf @method('PATCH')
                <input type="number" name="qty" value="{{ $row->qty }}" min="0"
                       class="form-control w-50">
                <button class="btn btn-outline-primary btn-sm ms-2">↻</button>
              </form>
            </td>
            <td>${{ number_format($row->subtotal, 0) }}</td>
            <td>
              <form action="{{ route('cart.remove', $row->rowId) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">✖</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="text-end">
      <h3>Total: ${{ number_format(Cart::total(), 0) }}</h3>
      <a href="#" class="btn btn-success btn-lg mt-3">Continuar al pago</a>
    </div>
  @else
    <p>No hay productos en tu carrito.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">Volver a la tienda</a>
  @endif
</div>
@endsection
