@extends('layouts.app')
@section('page-title', 'Medicines')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-pills me-2"></i>Medicine Inventory</span>
        <a href="{{ route('medicines.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add Medicine</a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search medicine..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="stock_status" class="form-select form-select-sm">
                    <option value="">All Stock Status</option>
                    <option value="low" {{ request('stock_status')=='low'?'selected':'' }}>Low Stock</option>
                    <option value="ok" {{ request('stock_status')=='ok'?'selected':'' }}>In Stock</option>
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Filter</button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
<th>ID</th><th>Generic Name</th><th>Brand</th><th>Category</th><th>Price</th><th>Stock</th><th>Regulated</th><th>Actions</th>
            <tbody>
            @forelse($medicines as $med)
            <tr class="{{ $med->isLowStock() ? 'table-warning' : '' }}">
                <td><span class="badge bg-primary">{{ $med->medicine_id_number }}</span></td>
                <td class="fw-bold">{{ $med->generic_name }}</td>

                <td>{{ $med->brand_name ?? '-' }}</td>
                <td><span class="badge bg-info">{{ $med->category->name }}</span></td>
                <td>₱{{ number_format($med->unit_price,2) }}</td>
                <td>
                    {{ $med->stock_level }}
                    @if($med->isLowStock()) <span class="badge bg-danger ms-1">Low</span> @endif
                </td>
                <td>{{ $med->is_regulated ? '✅ Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('medicines.show',$med) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('medicines.edit',$med) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                    <form method="POST" action="{{ route('medicines.destroy',$med) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    No medicines yet. <a href="{{ route('medicines.create') }}">Add first medicine</a>.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $medicines->withQueryString()->links() }}</div>
</div>
@endsection
