<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller {
    public function showRegistrationForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pharmacist,sales_clerk',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending', // Needs admin approval
        ]);
        
        // Only set user_id_number if the column exists.
        // In some deployments (e.g. fresh DB), the column may not be migrated yet.
        try {
            if (Schema::hasColumn('users', 'user_id_number')) {
                $idNumber = 'USR' . str_pad($user->id, 3, '0', STR_PAD_LEFT);
                $user->update(['user_id_number' => $idNumber]);
            }
        } catch (\Throwable $e) {
            // Ignore: column might not exist yet.
        }


        return redirect()->route('login')
            ->with('success', 'Registration submitted! Please wait for admin approval before logging in.');
    }
}
