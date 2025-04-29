<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//product api
Route::get('/getProduct', [ProductController::class, 'get']);

// orders api
Route::post('/order', [OrderController::class, 'store']);
Route::get('/order/{id}', [OrderController::class, 'show']);


//discount api
// Route::apiResources(['discount' => DiscountController::class]);
Route::get('/getDiscounts', [DiscountController::class, 'index'])->middleware('auth:sanctum');
Route::post('/updateDiscount/{id}', [DiscountController::class, 'update'])->middleware('auth:sanctum');
Route::post('/saveDiscount', [DiscountController::class, 'store'])->middleware('auth:sanctum');
Route::put('/updateDiscount/{id}', [DiscountController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/deleteDiscount/{id}', [DiscountController::class, 'destroy'])->middleware('auth:sanctum');

//customer api
Route::get('/getCustomers', [CustomerController::class, 'index'])->middleware('auth:sanctum');
Route::post('/loginCustomer', [CustomerController::class, 'login']);
Route::post('/storeCustomer', [CustomerController::class, 'store']);
Route::post('/updateCustomer/{id}', [CustomerController::class, 'update'])->middleware('auth:sanctum');
Route::get('/deleteCustomer/{id}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

//reservation api
Route::get('/getReservations', [ReservationController::class, 'get'])->middleware('auth:sanctum');
Route::post('/saveReservation', [ReservationController::class, 'store'])->middleware('auth:sanctum');
Route::post('/updateReservation/{id}', [ReservationController::class, 'updateReservation'])->middleware('auth:sanctum');







