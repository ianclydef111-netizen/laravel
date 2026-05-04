@extends('layouts.app')
@section('page-title', 'New Sale')
@section('content')
<div class="card">
    <div class="card-body">
        <h5><i class="fa fa-cash-register me-2"></i>New Point of Sale</h5>
        <p>Select medicines to sell. Auto-calculates total.</p>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sales.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <h6>Medicines</h6>
                    <div id="sale-items">
                        <div class="sale-item row mb-3 border p-3 rounded">
                            <div class="col-md-5">
                                <label class="form-label">Medicine</label>
                                <select name="sale_items[0][medicine_id]" class="form-select medicine-select" required>
                                    <option value="">Select Medicine</option>
                                    @foreach($medicines as $med)
                                        <option value="{{ $med->id }}" data-price="{{ $med->unit_price }}">
                                            {{ $med->generic_name }} {{ $med->brand_name ? '( ' . $med->brand_name . ' )' : '' }} - {{ $med->category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="sale_items[0][quantity]" class="form-control qty" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price/Unit</label>
                                <input type="number" class="form-control price" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Subtotal</label>
                                <input type="number" class="form-control subtotal" readonly>
                            </div>
                            <div class="col-md-1 align-self-end">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-item">×</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="btn btn-outline-primary btn-sm">+ Add Medicine</button>
                </div>
                <div class="col-md-4">
                    <h6>Summary</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Customer (optional)</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prescription (optional)</label>
                                <select name="prescription_id" class="form-select">
                                    <option value="">Walk-in</option>
                                    @foreach($prescriptions as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->patient_name }} - {{ $p->prescription_date->format('M d, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong id="grand-total">₱0.00</strong>
                            </div>
                            <button type="submit" class="btn btn-success w-100" id="complete-sale" disabled>Complete Sale</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = 1;
document.getElementById('add-item').onclick = function() {
    const container = document.getElementById('sale-items');
    const newItem = container.children[0].cloneNode(true);
    newItem.querySelector('select').name = `sale_items[${itemCount}][medicine_id]`;
    newItem.querySelector('.qty').name = `sale_items[${itemCount}][quantity]`;
    newItem.querySelector('.remove-item').onclick = function() {
        newItem.remove();
        updateGrandTotal();
    };
    newItem.querySelector('.medicine-select').onchange = updatePrice;
    newItem.querySelector('.qty').oninput = updateSubtotal;
    newItem.querySelector('select').value = '';
    newItem.querySelector('.qty').value = '';
    container.appendChild(newItem);
    itemCount++;
};

document.querySelectorAll('.medicine-select').forEach(sel => sel.onchange = updatePrice);
document.querySelectorAll('.qty').forEach(qty => qty.oninput = updateSubtotal);

function updatePrice(e) {
    const row = e.target.closest('.sale-item');
    const price = e.target.selectedOptions[0]?.dataset.price || 0;
    row.querySelector('.price').value = price;
    updateSubtotal({target: row.querySelector('.qty')});
}

function updateSubtotal(e) {
    const row = e.target.closest('.sale-item');
    const qty = parseFloat(e.target.value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const subtotal = qty * price;
    row.querySelector('.subtotal').value = subtotal;
    updateGrandTotal();
}

function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(sub => {
        total += parseFloat(sub.value) || 0;
    });
    document.getElementById('grand-total').textContent = '₱' + total.toFixed(2);
    document.getElementById('complete-sale').disabled = total === 0;
}
</script>
@endsection
