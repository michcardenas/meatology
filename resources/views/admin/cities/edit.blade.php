@extends('layouts.app')

@section('content')
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
                <label for="tax" class="form-label">Tax (%)</label>
                <input type="number" name="tax" id="tax" class="form-control" 
                       value="{{ old('tax', $city->tax) }}" 
                       step="0.01" min="0" max="999.99" placeholder="Optional tax percentage">
                @error('tax')
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