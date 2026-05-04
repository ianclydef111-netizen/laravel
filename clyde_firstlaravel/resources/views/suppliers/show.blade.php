@extends('layouts.app')
@section('page-title', 'Supplier Details')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-truck me-2"></i>Supplier #{{ $supplier->supplier_id_number_display }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{ $supplier->supplier_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Contact No</strong></td>
                        <td>{{ $supplier->contact_no }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $supplier->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Medicines Supplied</strong></td>
                        <td>{{ $supplier->medicines()->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
</div>
@endsection

