@extends('layouts.app')
@section('page-title', 'Suppliers')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-truck text-primary me-2"></i>Suppliers</span>
        <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add Supplier</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Medicines Supplied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers ?? [] as $supplier)
                    <tr>
                        <td><span class="badge bg-primary">{{ $supplier->supplier_id_number_display }}</span></td>
                        <td class="fw-bold">{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->contact_no }}</td>
                        <td>{{ $supplier->email ?? '-' }}</td>
                        <td>{{ $supplier->medicines()->count() }}</td>
                        <td>
                            <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="d-inline" onsubmit="return confirm('Delete supplier?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No suppliers. <a href="{{ route('suppliers.create') }}">Add one</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

