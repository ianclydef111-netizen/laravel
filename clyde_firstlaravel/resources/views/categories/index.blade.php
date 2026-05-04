@extends('layouts.app')
@section('page-title', 'Categories')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-tags text-primary me-2"></i>Medicine Categories</span>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add Category</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Medicines Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                <tr>
                        <td>
                            <strong>{{ $category->category_id_number_display }}</strong>
                            <br><small class="text-muted">{{ $category->name }}</small>
                        </td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $category->medicines_count }}</span></td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Delete this category? Medicines will be affected.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No categories found. <a href="{{ route('categories.create') }}">Create one now</a>.</td>
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
