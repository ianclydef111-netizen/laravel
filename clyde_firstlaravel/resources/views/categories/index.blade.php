@extends('layouts.app')
@section('page-title', 'Categories')
@section('content')
<div class="card">
    <div class="card-header bg-transparent py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fa fa-tags text-primary me-2"></i>Medicine Categories</h5>
            <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i>Add Category</a>
        </div>
        
        <form action="{{ route('categories.index') }}" method="GET" class="row g-2">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search categories by name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Medicines Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                <tr>
                        <td><span class="badge rounded-pill bg-primary">{{ $category->category_id_number_display }}</span></td>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $category->medicines_count }}</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Delete this category? Medicines will be affected.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No categories found. <a href="{{ route('categories.create') }}">Create one now</a>.</td>

                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
</div>
@endsection
