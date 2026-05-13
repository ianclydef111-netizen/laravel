@extends('layouts.app')
@section('page-title', 'Edit Supplier')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5><i class="fa fa-edit me-2"></i>Edit Supplier: {{ $supplier->supplier_name }}</h5>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Back</a>
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

        <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">ID Number</label>
                    <input type="text" class="form-control bg-light" readonly value="{{ $supplier->supplier_id_number_display }}">
                    <small class="text-muted">Auto-generated</small>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                    <input type="text" name="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror" value="{{ old('supplier_name', $supplier->supplier_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact No <span class="text-danger">*</span></label>
                    <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" value="{{ old('contact_no', $supplier->contact_no) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $supplier->contact_person) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $supplier->address) }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
