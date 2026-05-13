@extends('layouts.app')
@section('page-title', 'Medicine Details')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa fa-pills text-primary me-2"></i>{{ $medicine->generic_name }}</h5>
                <span class="badge bg-primary">{{ $medicine->medicine_id_number }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Generic Name</label>
                        <p class="fw-bold">{{ $medicine->generic_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Brand Name</label>
                        <p class="fw-bold">{{ $medicine->brand_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Category</label>
                        <p>{{ $medicine->category->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Supplier</label>
                        <p>{{ $medicine->supplier->supplier_name ?? 'No Supplier Assigned' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small d-block">Unit Price</label>
                        <p class="text-success fw-bold">₱{{ number_format($medicine->unit_price, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small d-block">Stock Level</label>
                        <p class="fw-bold {{ $medicine->stock_level <= $medicine->reorder_level ? 'text-danger' : 'text-primary' }}">
                            {{ $medicine->stock_level }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small d-block">Status</label>
                        @if($medicine->is_regulated)
                            <span class="badge bg-warning text-dark">Regulated</span>
                        @else
                            <span class="badge bg-info">General</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <label class="text-muted small d-block">Description</label>
                        <p>{{ $medicine->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fa fa-boxes me-2"></i>Inventory Batches</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Batch No</th>
                                <th>Quantity</th>
                                <th>Manufacture</th>
                                <th>Expiry</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicine->batches as $batch)
                            <tr>
                                <td>{{ $batch->batch_number }}</td>
                                <td>{{ $batch->stock_quantity }}</td>
                                <td>{{ $batch->manufacture_date ? $batch->manufacture_date->format('M Y') : '-' }}</td>
                                <td>{{ $batch->expiry_date->format('M Y') }}</td>
                                <td>
                                    @if(now()->gt($batch->expiry_date))
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif(now()->diffInDays($batch->expiry_date) < 30)
                                        <span class="badge bg-warning">Expiring</span>
                                    @else
                                        <span class="badge bg-success">OK</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No batches found for this medicine.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-warning w-100 mb-2"><i class="fa fa-edit me-1"></i>Edit Details</a>
                <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary w-100"><i class="fa fa-arrow-left me-1"></i>Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
