@extends('layouts.app_admin')

@section('content')
<style>
    /* Texto blanco en general */
    body, .container, .table, .form-control, .form-select, .alert, .btn {
        color: white !important;
    }

    /* Inputs y selects oscuros */
    .form-control, .form-select {
        background-color: #333 !important;
        border: 1px solid #555;
    }

    /* Placeholder blanco */
    ::placeholder {
        color: #ccc !important;
        opacity: 1;
    }
    :-ms-input-placeholder { /* IE 10-11 */
        color: #ccc !important;
    }
    ::-ms-input-placeholder { /* Edge */
        color: #ccc !important;
    }

    /* Labels */
    .form-label {
        color: white !important;
    }

    /* Alertas */
    .alert-success {
        background-color: #2d572c;
        color: #fff;
    }

    /* Botones personalizados */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    /* Error text */
    .text-danger {
        color: #ff6b6b !important;
    }
</style>
<div class="container py-4">
    <h2 class="mb-4">✏️ Edit City</h2>

    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">City Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $city->name) }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="country_id" class="form-label">Country</label>
                <select name="country_id" id="country_id" class="form-select" required>
                    <option value="">Select country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" 
                                {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="shipping" class="form-label">Shipping (USD)</label>
                <input type="number" name="shipping" id="shipping" class="form-control"
                       value="{{ old('shipping', $city->shipping) }}"
                       step="0.01" min="0" max="999.99" placeholder="Shipping cost in USD">
                <small class="text-muted">Optional shipping cost in USD</small>
                @error('shipping')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update City</button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection