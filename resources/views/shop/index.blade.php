@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #011904;
        color: #ffffff;
    }
    h1 {
        color: #f7a831;
    }
    .card {
        background-color: #02280a;
        border: 1px solid #0f3f20;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
    .card-title, .card-text, .h5 {
        color: #ffffff;
    }
    .btn-primary {
        background-color: #f7a831;
        border: none;
        color: #000;
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #e69b1f;
    }
</style>

<div class="container py-5">
  <h1 class="mb-5 text-center">Catálogo Meatology 🥩</h1>

  <div class="row">
    @foreach ($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ $product->image ? Storage::url($product->image) : asset('images/placeholder.jpg') }}"
               class="card-img-top" style="height:250px;object-fit:cover;">

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
            <p class="h5 mb-3">${{ number_format($product->price, 0) }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <button class="btn btn-primary w-100">Añadir al carrito</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
</div>
@endsection
