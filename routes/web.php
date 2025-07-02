<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\StoreProfileController; 
use App\Http\Controllers\LaporanController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/image/logo/{filename}', function ($filename) {
    $path = storage_path('app/public/logo/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Access-Control-Allow-Origin' => '*',
        'Content-Type' => mime_content_type($path),
    ]);
});

Route::get('/', function () {
    return view('pages.auth.login');
});

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Route for dashboard that uses DashboardController
    Route::get('home', [DashboardController::class, 'dashboard'])->name('home'); // Menghubungkan ke DashboardController

    // Resource routes for CRUD operations
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('reservation', ReservationController::class);
    Route::resource('order', OrderController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('discount', DiscountController::class);
    Route::resource('deposit', DepositController::class);

    // Specific routes for 'order' and 'deposit'
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::put('/order/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::put('/deposit/{deposit}', [DepositController::class, 'update'])->name('deposit.update');

    Route::get('/store-profile', [StoreProfileController::class, 'index'])->name('store.profile');
    Route::post('/store-profile', [StoreProfileController::class, 'store']);
    Route::get('/store-profile/edit', [StoreProfileController::class, 'edit'])->name('store.profile.edit');
    Route::put('/store-profile', [StoreProfileController::class, 'update'])->name('store.profile.update');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
    Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export');
});
