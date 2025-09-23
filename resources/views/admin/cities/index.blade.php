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

    /* Tabla fondo oscuro */
    .table {
        background-color: #222;
    }

    .table th, .table td {
        color: white !important;
    }

    .table-light th {
        background-color: #444 !important;
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

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
</style>


<div class="container py-4">
    <h2 class="mb-4">🏙️ Manage Cities</h2>

    <!-- Create City -->
    <form action="{{ route('admin.cities.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="City name..." required>
            </div>
            <div class="col-md-3">
                <select name="country_id" class="form-select" required>
                    <option value="">Select country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="tax" class="form-control" placeholder="Tax (%)" step="0.01" min="0" max="999.99">
                <small class="text-muted">Optional tax %</small>
            </div>
            <div class="col-md-3">
                <input type="number" name="shipping" class="form-control" placeholder="Shipping Cost (USD)" step="0.01" min="0">
                <small class="text-muted">Shipping cost in USD</small>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Add City</button>
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Cities Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Country</th>
                <th>Tax (%)</th>
                <th>Shipping (USD)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cities as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->country->name }}</td>
                    <td>
                        @if($city->tax)
                            {{ number_format($city->tax, 2) }}%
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($city->shipping)
                            ${{ number_format($city->shipping, 2) }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        {{-- Future edit button --}}
                        <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <!-- Delete -->
                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this city?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No cities found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
