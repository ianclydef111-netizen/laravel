<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BatchController extends Controller {
    public function index(Request $request) {
$query = Batch::with('medicine.supplier');
        if ($request->filled('search')) $query->whereHas('medicine', fn($q) => $q->where('generic_name', 'like', '%'.$request->search.'%'));
        if ($request->filled('expiry_status')) {
            if ($request->expiry_status === 'expired') $query->where('expiry_date', '<', now());
            if ($request->expiry_status === 'expiring_soon') $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
            if ($request->expiry_status === 'ok') $query->where('expiry_date', '>', now()->addDays(30));
        }
        $batches = $query->orderBy('expiry_date')->paginate(15);
        return view('batches.index', compact('batches'));
    }

    public function create() {
        $medicines = Medicine::with('supplier', 'category')->get();
        return view('batches.create', compact('medicines'));
    }

    public function store(Request $request) {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'batch_number' => 'required',
            'expiry_date' => 'required|date',
            'manufacture_date' => 'nullable|date', // Added validation for manufacture_date
            'stock_quantity' => 'required|integer|min:1',
        ]);
        $batch = Batch::create($request->all());
        
        try {
            $idNumber = 'BAT' . str_pad($batch->id, 3, '0', STR_PAD_LEFT);
            if (Schema::hasColumn('batches', 'batch_id_number')) {
                $batch->update(['batch_id_number' => $idNumber]);
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet
        }
        
        // Update medicine stock
        $batch->medicine->increment('stock_level', $batch->stock_quantity);
        return redirect()->route('batches.index')->with('success', 'Batch added (ID: ' . $batch->batch_id_number_display . ').');
    }

    public function destroy(Batch $batch) {
        $batch->delete();
        return back()->with('success', 'Batch deleted.');
    }
}