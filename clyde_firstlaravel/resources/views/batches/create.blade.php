@extends('layouts.app')
@section('page-title', 'Add Batch')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5><i class="fa fa-plus-circle me-2"></i>Add Batch</h5>
            <a href="{{ route('batches.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('batches.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">ID Number</label>
                    <input type="text" class="form-control bg-light" readonly value="BAT{{ str_pad(rand(1,999), 3, '0', STR_PAD_LEFT) }}">
                    <small class="text-muted">Auto-generated</small>
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <label class="form-label">Medicine <span class="text-danger">*</span></label>
                    <select name="medicine_id" class="form-select @error('medicine_id') is-invalid @enderror" required>
                        <option value="">Select Medicine</option>
                        @foreach(App\Models\Medicine::with('category')->get() as $med)
                            <option value="{{ $med->id }}" {{ old('medicine_id') == $med->id ? 'selected' : '' }}>
                                {{ $med->generic_name }} - {{ $med->category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Batch Number <span class="text-danger">*</span></label>
                    <input type="text" name="batch_number" class="form-control @error('batch_number') is-invalid @enderror" value="{{ old('batch_number') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity') }}" required min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Manufacture Date</label>
                    <input type="date" name="manufacture_date" class="form-control @error('manufacture_date') is-invalid @enderror" value="{{ old('manufacture_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Batch</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
