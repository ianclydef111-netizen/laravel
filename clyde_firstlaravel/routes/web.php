<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;

// Landing page
Route::get('/', fn() => view('landing'))->name('home');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/admin/users/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.approve');
        Route::post('/admin/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('admin.reject');
        Route::post('/admin/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('admin.toggle');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
    });

    // Admin & Pharmacist - Full access to prescriptions
    Route::middleware('role:admin,pharmacist')->group(function () {
        Route::resource('medicines', MedicineController::class);
        Route::resource('batches', BatchController::class)->except(['edit', 'update', 'show']);
        Route::resource('prescriptions', PrescriptionController::class);
    });

    // Sales Clerk & Admin
    Route::middleware('role:admin,sales_clerk')->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });
});
