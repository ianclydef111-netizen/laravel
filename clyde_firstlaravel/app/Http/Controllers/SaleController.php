<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'prescription'])->latest()->paginate(20);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $medicines = Medicine::where('stock_level', '>', 0)->get();
        $prescriptions = Prescription::where('status', 'approved')->get();
        return view('sales.create', compact('medicines', 'prescriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prescription_id' => 'nullable|exists:prescriptions,id',
            'sale_items' => 'required|array|min:1',
            'sale_items.*.medicine_id' => 'required|exists:medicines,id',
            'sale_items.*.quantity' => 'required|integer|min:1',
            'sale_items.*.price_per_unit' => 'nullable|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        
        try {
            $totalPrice = 0;
            $saleItemsData = [];

            foreach ($request->sale_items as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
$price = $item['price_per_unit'] ?? $medicine->unit_price ?? 0;
$totalPrice += $item['quantity'] * $price;

                // Check stock
                if ($medicine->stock_level < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$medicine->generic_name}");
                }

                $saleItemsData[] = [
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
'price_per_unit' => $price,
'subtotal' => $item['quantity'] * $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $sale = Sale::create([
                'user_id' => Auth::id(),
                'prescription_id' => $request->prescription_id,
                'sale_date' => now(),
                'total_price' => $totalPrice,
                'customer_name' => $request->customer_name,
            ]);

            foreach ($saleItemsData as $itemData) {
                $saleItem = $sale->saleItems()->create($itemData);
                
                // Update medicine stock
                $medicine = Medicine::find($itemData['medicine_id']);
                $medicine->decrement('stock_level', $itemData['quantity']);
                
                // Update batch stock if available
                $batch = $medicine->batches()->where('stock_quantity', '>', 0)->first();
                if ($batch) {
                    $batch->decrement('stock_quantity', $itemData['quantity']);
                }
            }

            DB::commit();
            
            return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'prescription', 'saleItems.medicine']);
        return view('sales.show', compact('sale'));
    }
}

