<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function dashboard() {
        $stats = [
            'pending_users' => User::where('status', 'pending')->count(),
            'total_medicines' => Medicine::count(),
            'low_stock' => Medicine::whereColumn('stock_level', '<=', 'reorder_level')->count(),
            'today_sales' => Sale::whereDate('sale_date', today())->sum('total_price'),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request) {
        $query = User::where('role', '!=', 'admin');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('role')) $query->where('role', $request->role);
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function approveUser(User $user) {
        DB::transaction(function () use ($user) {
            User::where('id', $user->id)->update(['status' => 'active']);
        });
        return back()->with('success', "User {$user->name} has been approved.");
    }

    public function rejectUser(User $user) {
        DB::transaction(function () use ($user) {
            User::where('id', $user->id)->update(['status' => 'inactive']);
        });
        return back()->with('success', "User {$user->name} has been rejected.");
    }

    public function toggleUser(User $user) {
        DB::transaction(function () use ($user) {
            $newStatus = $user->status === 'active' ? 'inactive' : 'active';
            User::where('id', $user->id)->update(['status' => $newStatus]);
        });
        return back()->with('success', "User status updated.");
    }

    public function destroy(User $user) {
        DB::transaction(function () use ($user) {
            User::where('id', $user->id)->delete();
        });
        return back()->with('success', "User {$user->name} has been deleted.");
    }
}

