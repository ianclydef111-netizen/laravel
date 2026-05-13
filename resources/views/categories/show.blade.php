@extends('layouts.app')
@section('page-title', 'Category Details')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa fa-tags text-primary me-2"></i>{{ $category->name }}</h5>
                <span class="badge bg-primary">{{ $category->category_id_number_display }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">ID Number</label>
                        <p class="fw-bold">{{ $category->category_id_number_display }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Medicines Count</label>
                        <p><span class="badge bg-info">{{ $category->medicines_count ?? $category->medicines()->count() }}</span></p>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small d-block">Description</label>
                        <p>{{ $category->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($category->medicines->count() > 0)
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fa fa-pills me-2"></i>Medicines in this Category</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Generic Name</th>
                                <th>Brand</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->medicines as $medicine)
                            <tr>
                                <td>{{ $medicine->generic_name }}</td>
                                <td>{{ $medicine->brand_name ?? '-' }}</td>
                                <td>{{ $medicine->stock_level }}</td>
                                <td>
                                    @if($medicine->stock_level == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($medicine->stock_level <= $medicine->reorder_level)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No medicines in this category.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning w-100 mb-2"><i class="fa fa-edit me-1"></i>Edit Category</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary w-100"><i class="fa fa-arrow-left me-1"></i>Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
