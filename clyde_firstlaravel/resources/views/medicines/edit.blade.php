@extends('layouts.app')
@section('page-title', 'Edit Medicine')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fa fa-edit text-primary me-2"></i>Edit Medicine: {{ $medicine->generic_name }}</h4>
    <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('medicines.update', $medicine) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Generic Name <span class="text-danger">*</span></label>
                    <input type="text" name="generic_name" class="form-control @error('generic_name') is-invalid @enderror" value="{{ old('generic_name', $medicine->generic_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="brand_name" class="form-control @error('brand_name') is-invalid @enderror" value="{{ old('brand_name', $medicine->brand_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $medicine->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit Price ($) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price', $medicine->unit_price) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stock Level</label>
                    <input type="number" name="stock_level" class="form-control @error('stock_level') is-invalid @enderror" value="{{ old('stock_level', $medicine->stock_level) }}" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Reorder Level</label>
                    <input type="number" name="reorder_level" class="form-control @error('reorder_level') is-invalid @enderror" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="0">
                </div>
                <div class="col-12">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_regulated" class="form-check-input" value="1" {{ old('is_regulated', $medicine->is_regulated) ? 'checked' : '' }}>
                        Regulated Medicine (requires prescription)
                    </label>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Update Medicine</button>
                    <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
