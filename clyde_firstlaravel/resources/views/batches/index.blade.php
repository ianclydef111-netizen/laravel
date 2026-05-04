@extends('layouts.app')
@section('page-title', 'Batches')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-boxes text-primary me-2"></i>Batches & Expiry</span>
        <a href="{{ route('batches.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add Batch</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Batch No</th>
                        <th>Stock Quantity</th>
                        <th>Manufacture Date</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches ?? [] as $batch)
                    <tr class="{{ now()->diffInDays($batch->expiry_date) < 30 ? 'table-warning' : '' }}">
                        <td>
                            <strong>{{ $batch->batch_id_number_display }}</strong>
                            <br><small class="text-muted">{{ $batch->medicine->generic_name }}</small>
                        </td>
                        <td>{{ $batch->batch_number }}</td>
                        <td><span class="badge bg-info">{{ $batch->stock_quantity }}</span></td>
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
                        <td>
                            <form method="POST" action="{{ route('batches.destroy', $batch) }}" class="d-inline" onsubmit="return confirm('Delete batch?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No batches. <a href="{{ route('batches.create') }}">Add one</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
