@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('content')
<div class="row g-4 mb-4">
    @if(auth()->user()->isAdmin())
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #28a745;"><div style="opacity:.7;font-size:.8rem;">PENDING APPROVALS</div><div style="font-size:2rem;font-weight:800;">{{ $data['pending_users'] }}</div><i class="fa fa-users-cog" style="opacity:.4;font-size:2rem;float:right;margin-top:-2rem;"></i></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #0ba8ff;"><div style="opacity:.7;font-size:.8rem;">TODAY'S SALES</div><div style="font-size:2rem;font-weight:800;">₱{{ number_format($data['today_sales'],2) }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #6f42c1;"><div style="opacity:.7;font-size:.8rem;">TOTAL MEDICINES</div><div style="font-size:2rem;font-weight:800;">{{ $data['total_medicines'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #dc3545;"><div style="opacity:.7;font-size:.8rem;">LOW STOCK ITEMS</div><div style="font-size:2rem;font-weight:800;">{{ $data['low_stock'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #fd7e14;"><div style="opacity:.7;font-size:.8rem;">THIS MONTH SALES</div><div style="font-size:2rem;font-weight:800;">₱{{ number_format($data['month_sales'],2) }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #198754;"><div style="opacity:.7;font-size:.8rem;">THIS YEAR SALES</div><div style="font-size:2rem;font-weight:800;">₱{{ number_format($data['year_sales'],2) }}</div></div></div>
    @endif

    @if(auth()->user()->isPharmacist())
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #dc3545;"><div style="opacity:.7;font-size:.8rem;">LOW STOCK</div><div style="font-size:2rem;font-weight:800;">{{ $data['low_stock'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #fd7e14;"><div style="opacity:.7;font-size:.8rem;">EXPIRING SOON</div><div style="font-size:2rem;font-weight:800;">{{ $data['expiring_batches'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #6f42c1;"><div style="opacity:.7;font-size:.8rem;">PENDING RX</div><div style="font-size:2rem;font-weight:800;">{{ $data['pending_prescriptions'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card" style="border-left:4px solid #28a745;"><div style="opacity:.7;font-size:.8rem;">TOTAL MEDICINES</div><div style="font-size:2rem;font-weight:800;">{{ $data['total_medicines'] }}</div></div></div>
    @endif

    @if(auth()->user()->isSalesClerk())
    <div class="col-md-4"><div class="stat-card" style="border-left:4px solid #28a745;"><div style="opacity:.7;font-size:.8rem;">MY SALES TODAY</div><div style="font-size:2rem;font-weight:800;">{{ $data['today_sales'] }}</div></div></div>
    <div class="col-md-4"><div class="stat-card" style="border-left:4px solid #0ba8ff;"><div style="opacity:.7;font-size:.8rem;">TODAY'S REVENUE</div><div style="font-size:2rem;font-weight:800;">₱{{ number_format($data['today_revenue'],2) }}</div></div></div>
    @endif
</div>

@if(auth()->user()->isAdmin() || auth()->user()->isPharmacist())
@if(count($data['expiring_soon_list']) > 0)
<div class="card mb-4">
<div class="card-header py-3 d-flex align-items-center">
<i class="fa fa-exclamation-triangle text-warning me-2"></i>
Expiring Medicines (within 30 days)
<span class="badge bg-warning ms-auto">{{ $data['expiring_batches'] }} batch{{ $data['expiring_batches'] > 1 ? 'es' : '' }}</span>
</div>
<div class="card-body p-0">
<div class="table-responsive">
<table class="table mb-0 table-hover">
<thead class="table-light">
<tr>
<th>Medicine</th>
<th>Batch #</th>
<th>Expiry Date</th>
<th>Days Left / Status</th>
<th>Available Stock</th>
</tr>
</thead>
<tbody>
@foreach($data['expiring_soon_list'] as $batch)
@php
    // 1. Ensure we only compare dates, not times, to avoid decimals/partial days
    $now = now()->startOfDay(); 
    $expiryDate = $batch->expiry_date->startOfDay(); 
    
    // 2. Use diffInDays. A negative result means the expiry date is in the past.
    // We compare ($now) to ($expiryDate). 
    // If $expiry is May 30 and $now is May 29, $daysLeft will be 1.
    $daysLeft = $now->diffInDays($expiryDate, false); 

    $badgeClass = '';
    $badgeText = '';
    $trClass = '';

    if ($daysLeft < 0) { 
        // Logic: Expiry date is before today
        $badgeClass = 'bg-danger';
        $badgeText = 'Expired';
        $trClass = 'table-danger';
    } elseif ($daysLeft == 0) { 
        // Logic: Expiry date is exactly today
        $badgeClass = 'bg-danger';
        $badgeText = 'Expires Today';
        $trClass = 'table-danger';
    } elseif ($daysLeft <= 7) { 
        // Logic: 1 to 7 days remaining
        $badgeClass = 'bg-danger';
        $badgeText = $daysLeft . ' days left';
        $trClass = 'table-danger';
    } elseif ($daysLeft <= 14) { 
        // Logic: 8 to 14 days remaining
        $badgeClass = 'bg-warning text-dark';
        $badgeText = $daysLeft . ' days left';
        $trClass = 'table-warning';
    } else { 
        // Logic: 15 to 30 days remaining
        $badgeClass = 'bg-info text-dark';
        $badgeText = $daysLeft . ' days left';
        $trClass = 'table-info';
    }
@endphp
<tr class="{{ $trClass }}">
    <td>
        <strong>{{ $batch->medicine->generic_name }}</strong><br>
        <small class="text-muted">{{ $batch->medicine->brand_name }}</small>
    </td>
    <td><code>{{ $batch->batch_number }}</code></td>
    <td>{{ $batch->expiry_date->format('M d, Y') }}</td>
    <td>
        <span class="badge {{ $badgeClass }}">
            {{ $badgeText }}
        </span>
    </td>
    <td>{{ number_format($batch->stock_quantity) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
@else
<div class="alert alert-success mb-4">
<i class="fa fa-check-circle"></i> Great! No medicines are expiring within the next 30 days.
</div>
@endif
@endif

@if(isset($data['recent_sales']))
<div class="card"><div class="card-header py-3">Recent Sales</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Sale ID</th><th>Customer</th><th>Date</th><th>Amount</th><th>Clerk</th></tr></thead>
            <tbody>
            @foreach($data['recent_sales'] as $sale)
            <tr><td>#{{ $sale->id }}</td><td>{{ $sale->customer_name ?? 'Walk-in' }}</td><td>{{ $sale->sale_date }}</td><td>₱{{ number_format($sale->total_price,2) }}</td><td>{{ $sale->user->name }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div></div>
@endif
@endsection
