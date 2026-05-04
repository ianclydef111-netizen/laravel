@extends('layouts.app')
@section('page-title', 'Prescriptions')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-file-medical text-primary me-2"></i>Prescriptions</span>
        <a href="{{ route('prescriptions.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add Prescription</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">

                <thead class="table-light">
                    <tr class="align-middle">
                        <th style="width: 15%;">Patient</th>
                        <th style="width: 15%;">Doctor</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 10%;">File</th>
                        <th style="width: 20%;">Medicines</th>
                        <th style="width: 8%;">Status</th>
                        <th style="width: 12%;">Notes</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($prescriptions ?? [] as $prescription)

                    <tr class="align-middle">
                        <td class="fw-medium">
                            {{ $prescription->prescription_id_number_display }}
                            <br><small class="text-muted">{{ $prescription->patient_name }}</small>
                        </td>
                        <td>{{ $prescription->doctor_name }}</td>
                        <td>{{ $prescription->prescription_date->format('M d') }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $prescription->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a>
                        </td>
                        <td style="vertical-align: middle;">
                            @if($prescription->medicines->count())
                                @foreach($prescription->medicines->take(3) as $med)
                                    <div class="small text-truncate d-block">{{ $med->generic_name }} ({{ $med->pivot->quantity }})</div>
                                @endforeach
                                @if($prescription->medicines->count() > 3)
                                    <div class="small text-muted">+{{ $prescription->medicines->count() - 3 }} more</div>
                                @endif
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $prescription->status == 'pending' ? 'bg-warning' : ($prescription->status == 'approved' ? 'bg-success' : 'bg-secondary') }}">
                                {{ ucfirst($prescription->status) }}
                            </span>
                        </td>
                        <td class="text-truncate">{{ Str::limit($prescription->notes, 30) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-outline-primary"><i class="fa fa-eye"></i></a>
                                <form method="POST" action="{{ route('prescriptions.destroy', $prescription) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No prescriptions. <a href="{{ route('prescriptions.create') }}">Add one</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
