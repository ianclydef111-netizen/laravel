@extends('layouts.app')
@section('page-title', 'Prescription Details')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
<h5><i class="fa fa-file-medical me-2"></i>Prescription {{ $prescription->prescription_id_number_display }}</h5>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <strong>Patient:</strong> {{ $prescription->patient_name }}<br>
                        <strong>Doctor:</strong> {{ $prescription->doctor_name }}<br>
                        <strong>Date:</strong> {{ $prescription->prescription_date->format('M d, Y') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong> 
                        <span class="badge {{ $prescription->status == 'pending' ? 'bg-warning' : ($prescription->status == 'approved' ? 'bg-success' : 'bg-secondary') }}">
                            {{ ucfirst($prescription->status) }}
                        </span><br>
                        <strong>Created:</strong> {{ $prescription->created_at->format('M d, Y') }}
                    </div>
                </div>
                @if($prescription->notes)
                <hr>
                <strong>Notes:</strong>
                <p class="mb-0">{{ $prescription->notes }}</p>
                @endif
                <hr>
                <div class="text-center">
                    <a href="{{ asset('storage/' . $prescription->file_path) }}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-eye me-1"></i>View Prescription File
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary w-100 mb-2">Back</a>
                <form method="POST" action="{{ route('prescriptions.destroy', $prescription) }}" class="w-100" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
