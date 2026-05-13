@extends('layouts.app')
@section('page-title', 'Sale Details')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-receipt me-2"></i>Sale #{{ $sale->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Sale Date:</strong> {{ $sale->sale_date->format('M d, Y') }}<br>
                        <strong>Sold by:</strong> {{ $sale->user->name }}<br>
                        @if($sale->prescription_id)
                            <strong>Prescription:</strong> #{{ $sale->prescription_id }}<br>
                        @endif
                        <strong>Customer:</strong> {{ $sale->customer_name ?? 'Walk-in' }}
                    </div>
                    <div class="col-md-6 text-end">
                        <h3 class="text-primary">₱{{ number_format($sale->total_price, 2) }}</h3>
                    </div>
                </div>
                
                <hr>
                <h6>Sale Items:</h6>
                @if($sale->saleItems->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Medicine</th><th>Quantity</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $item)
                            <tr>
                                <td>{{ $item->medicine->generic_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No items in this sale.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100">Back to Sales</a>
            </div>
        </div>
    </div>
</div>
@endsection
