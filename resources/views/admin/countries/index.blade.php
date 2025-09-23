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
    <h2 class="mb-4">🌍 Manage State</h2>

    <!-- Create Country -->
    <form action="{{ route('admin.countries.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="New country name..." required>
            <button type="submit" class="btn btn-primary">Add Country</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Countries Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th># of Cities</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($countries as $country)
                <tr>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->cities_count }}</td>
                    <td>
                        {{-- Future edit button --}}
                        <button class="btn btn-sm btn-secondary" disabled>Edit</button>

                        <!-- Delete -->
                        <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this country?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No countries found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
