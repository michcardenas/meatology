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
    <h2 class="mb-4">✏️ Edit State</h2>

    <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">State Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $country->name) }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="tax" class="form-label">Tax Rate (%)</label>
                <input type="number" name="tax" id="tax" class="form-control"
                       value="{{ old('tax', $country->tax) }}"
                       step="0.01" min="0" max="999999.99" placeholder="Tax rate percentage">
                <small class="text-muted">Tax rate in percentage (e.g., 8.5 for 8.5%)</small>
                @error('tax')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update State</button>
            <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection