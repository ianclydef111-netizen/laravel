@extends('layouts.app')
@section('page-title', 'Edit Category')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5><i class="fa fa-edit me-2"></i>Edit Category: {{ $category->name }}</h5>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back</a>
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

        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">ID Number</label>
                    <input type="text" class="form-control bg-light" readonly value="{{ $category->category_id_number_display }}">
                    <small class="text-muted">Auto-generated</small>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
