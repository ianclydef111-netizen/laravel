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

