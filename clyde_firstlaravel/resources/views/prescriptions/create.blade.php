@extends('layouts.app')
@section('page-title', 'Add Prescription')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5><i class="fa fa-plus-circle me-2"></i>Add Prescription</h5>
            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('prescriptions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">ID Number</label>
                    <input type="text" class="form-control bg-light" readonly value="PRE{{ str_pad(rand(1,999), 3, '0', STR_PAD_LEFT) }}">
                    <small class="text-muted">Auto-generated</small>
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-md-6">
                    <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                    <input type="text" name="patient_name" class="form-control @error('patient_name') is-invalid @enderror" value="{{ old('patient_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                    <input type="text" name="doctor_name" class="form-control @error('doctor_name') is-invalid @enderror" value="{{ old('doctor_name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prescription Date <span class="text-danger">*</span></label>
                    <input type="date" name="prescription_date" class="form-control @error('prescription_date') is-invalid @enderror" value="{{ old('prescription_date') }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Prescription File <span class="text-danger">*</span></label>
                    <input type="file" name="file_path" class="form-control @error('file_path') is-invalid @enderror" accept="image/*,application/pdf" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                </div>

                {{-- Prescribed Medicines --}}
                <div class="col-12">
                    <h6><i class="fa fa-pills me-2"></i>Prescribed Medicines <span class="text-danger">*</span></h6>
                    <div id="prescription-items">
                        <div class="prescription-item row g-3 mb-3 border p-3 rounded">
                            <div class="col-md-5">
                                <label>Medicine</label>
                                <select name="prescription_items[0][medicine_id]" class="form-select medicine-select" required>
                                    <option value="">Select Medicine</option>
                                    @foreach($medicines as $med)
                                        <option value="{{ $med->id }}">
                                            {{ $med->generic_name }} ({{ $med->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label>Quantity Prescribed</label>
                                <input type="number" name="prescription_items[0][quantity]" class="form-control qty" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item mt-1 w-100">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-prescription-item" class="btn btn-outline-primary btn-sm">+ Add Medicine</button>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Prescription</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = 1;
document.getElementById('add-prescription-item').onclick = () => {
    const container = document.getElementById('prescription-items');
    const newItem = container.children[0].cloneNode(true);
    newItem.querySelectorAll('input, select').forEach((el, i) => {
        el.name = el.name.replace(/\[\\d+\]/, `[${itemCount}]`);
        el.value = '';
    });
    newItem.querySelector('.remove-item').onclick = () => newItem.remove();
    container.appendChild(newItem);
    itemCount++;
};

document.querySelectorAll('.remove-item').forEach(btn => btn.onclick = () => btn.closest('.prescription-item').remove());
</script>
@endsection
