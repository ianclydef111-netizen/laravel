<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller {
    public function index(Request $request) {
        $query = Supplier::withCount('medicines');
        if ($request->filled('search')) $query->where('supplier_name', 'like', '%'.$request->search.'%');
        $suppliers = $query->paginate(15);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create() { return view('suppliers.create'); }

    public function store(Request $request) {
        $request->validate(['supplier_name' => 'required', 'contact_no' => 'required']);
        $supplier = Supplier::create($request->all());
        $supplier->supplier_id_number = 'SUP' . str_pad($supplier->id, 3, '0', STR_PAD_LEFT);
        $supplier->save();
        return redirect()->route('suppliers.index')->with('success', 'Supplier created (ID: ' . $supplier->supplier_id_number_display . ').');
    }

    public function edit(Supplier $supplier) { return view('suppliers.edit', compact('supplier')); }

    public function update(Request $request, Supplier $supplier) {
        $request->validate(['supplier_name' => 'required', 'contact_no' => 'required']);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated.');
    }

    public function show(Supplier $supplier) {
        return view('suppliers.show', compact('supplier'));
    }

    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted.');
    }
}
