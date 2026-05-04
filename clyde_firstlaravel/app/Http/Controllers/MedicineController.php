<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MedicineController extends Controller {
    public function index(Request $request) {
        $query = Medicine::with(['category', 'supplier']);
        if ($request->filled('search')) $query->where('generic_name', 'like', '%'.$request->search.'%')->orWhere('brand_name', 'like', '%'.$request->search.'%');
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') $query->whereColumn('stock_level', '<=', 'reorder_level');
            if ($request->stock_status === 'ok') $query->whereColumn('stock_level', '>', 'reorder_level');
        }
        $medicines = $query->paginate(15);
        $categories = Category::all();
        return view('medicines.index', compact('medicines', 'categories'));
    }

    public function create() {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('medicines.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request) {
        $request->validate([
            'generic_name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_price' => 'required|numeric|min:0',
            'stock_level' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'is_regulated' => 'boolean'
        ]);
        $data = $request->except('medicine_id_number');
        $medicine = new Medicine($data);
        $medicine->save();
        $medicine->medicine_id_number = 'MED' . str_pad($medicine->id, 3, '0', STR_PAD_LEFT);
        $medicine->save();
        return redirect()->route('medicines.index')->with('success', 'Medicine added.');
    }

    public function show(Medicine $medicine) {
        $medicine->load(['category', 'supplier', 'batches']);
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine) {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('medicines.edit', compact('medicine', 'categories', 'suppliers'));
    }

    public function update(Request $request, Medicine $medicine) {

        $request->validate([
            'generic_name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_price' => 'required|numeric|min:0',
        ]);
        $medicine->update($request->except('medicine_id_number'));
        return redirect()->route('medicines.index')->with('success', 'Medicine updated.');
    }

    public function destroy(Medicine $medicine) {
        $medicine->delete();
        return back()->with('success', 'Medicine deleted.');
    }
}