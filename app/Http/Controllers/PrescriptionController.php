<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class PrescriptionController extends Controller {
    public function index(Request $request) {
        $query = Prescription::query();
        if ($request->filled('search')) $query->where('patient_name', 'like', '%'.$request->search.'%')->orWhere('doctor_name', 'like', '%'.$request->search.'%');
        if ($request->filled('status')) $query->where('status', $request->status);
        $prescriptions = $query->latest()->paginate(15);
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create() {
        $medicines = Medicine::with('category')->get();
        return view('prescriptions.create', compact('medicines'));
    }

    public function store(Request $request) {
        $request->validate([
            'patient_name' => 'required',
            'doctor_name' => 'required',
            'prescription_date' => 'required|date',
            'file_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable',
            'prescription_items' => 'required|array|min:1',
            'prescription_items.*.medicine_id' => 'required|exists:medicines,id',
            'prescription_items.*.quantity' => 'required|integer|min:1',
        ]);

        $path = $request->file('file_path')->store('prescriptions', 'public');

        $prescription = Prescription::create([
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'prescription_date' => $request->prescription_date,
            'file_path' => $path,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        
        try {
            $idNumber = 'PRE' . str_pad($prescription->id, 3, '0', STR_PAD_LEFT);
            if (Schema::hasColumn('prescriptions', 'prescription_id_number')) {
                $prescription->update(['prescription_id_number' => $idNumber]);
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet
        }

        foreach ($request->prescription_items as $item) {
            $prescription->medicines()->attach($item['medicine_id'], [
                'quantity' => $item['quantity']
            ]);
        }

        return redirect()->route('prescriptions.index')->with('success', 'Prescription with medicines created.');
    }

    public function show(Prescription $prescription) {
        return view('prescriptions.show', compact('prescription'));
    }

    public function approve(Prescription $prescription) {
        $prescription->update(['status' => 'approved']);
        return back()->with('success', 'Prescription approved.');
    }

    public function destroy(Prescription $prescription) {
        Storage::disk('public')->delete($prescription->file_path);
        $prescription->delete();
        return back()->with('success', 'Prescription deleted.');
    }
}