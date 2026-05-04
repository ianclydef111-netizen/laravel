<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Batch;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();
        $data = [];

        if ($user->isAdmin()) {
            $data['pending_users'] = User::where('status', 'pending')->count();
            $data['today_sales'] = Sale::whereDate('sale_date', today())->sum('total_price');
            $data['month_sales'] = Sale::whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year)->sum('total_price');
            $data['year_sales'] = Sale::whereYear('sale_date', now()->year)->sum('total_price');
            $data['total_medicines'] = Medicine::count();
            $data['low_stock'] = Medicine::whereColumn('stock_level', '<=', 'reorder_level')->count();
            $data['recent_sales'] = Sale::with('user')->latest()->take(5)->get();
            $data['pending_prescriptions'] = Prescription::where('status', 'pending')->count();
        }

        if ($user->isPharmacist()) {
            $data['low_stock'] = Medicine::whereColumn('stock_level', '<=', 'reorder_level')->count();
            $data['expiring_batches'] = Batch::where('expiry_date', '<=', now()->addDays(30))->count();
            $data['pending_prescriptions'] = Prescription::where('status', 'pending')->count();
            $data['total_medicines'] = Medicine::count();
        }

        if ($user->isSalesClerk()) {
            $data['today_sales'] = Sale::where('user_id', $user->id)->whereDate('sale_date', today())->count();
            $data['today_revenue'] = Sale::where('user_id', $user->id)->whereDate('sale_date', today())->sum('total_price');
            $data['recent_sales'] = Sale::where('user_id', $user->id)->with('saleItems')->latest()->take(5)->get();
        }

        return view('dashboard', compact('data'));
    }
}