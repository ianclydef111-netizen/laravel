@extends('layouts.app')
@section('page-title', 'Sales')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-cash-register text-primary me-2"></i>Sales Records</span>
        <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>New Sale</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Prescription</th>
                        <th>Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales ?? [] as $sale)
                    <tr>
<td><span class="badge bg-primary">{{ $sale->sale_id_number ?? $sale->id }}</span></td>
                        <td>{{ $sale->user->name }}</td>
                        <td>{{ $sale->customer_name ?? 'Walk-in' }}</td>
                        <td>{{ $sale->sale_date->format('M d') }}</td>
                        <td><strong>₱{{ number_format($sale->total_price, 2) }}</strong></td>
                        <td>
                            @if($sale->prescription_id)
                                <span class="badge bg-info">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>{{ $sale->saleItems->count() }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No sales. <a href="{{ route('sales.create') }}">Make first sale</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
