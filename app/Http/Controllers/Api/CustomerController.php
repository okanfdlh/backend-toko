<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class CustomerController extends Controller
{

    // get
    public function index(){

        $customers = Customer::all();
        return response(['message' => 'success', 'data' => $customers], 200);
    }

    // store customer
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required',
            'password' => 'required|min:6' // Tambahkan validasi password
        ]);

        // Membuat customer baru dan menyimpan password yang di-hash
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password), // Hash password
        ]);

        // Return response
        return response()->json(['status' => 'success', 'data' => $customer], 200);
    }


    // update customer
    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required'
        ]);

        $customers = Customer::findOrfail($id);

        if(!$customers){
            return response()->json(['status' => 'error', 'message' => 'Customer not found'], 404);
        }
        $customers->update($request->all());

        return response()->json(['status' => 'data updated', 'data' => $customers], 200);
    }


    // delete customer
    public function destroy($id){

        $customers = Customer::findOrfail($id);

        if(!$customers){
            return response()->json(['status' => 'error', 'message' => 'Customer not found'], 404);
        }

        $customers->delete();
        return response()->json(['status' => 'customer deleted', 'data' => $customers], 200);
    }
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Mencari customer berdasarkan email
        $customer = Customer::where('email', $request->email)->first();

        // Jika customer tidak ditemukan atau password salah
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['status' => 'error', 'message' => 'Email atau password salah'], 401);
        }

        // Membuat token atau proses login lainnya
        // Anda bisa menggunakan Laravel Passport atau JWT untuk autentikasi token (gunakan token autentikasi di sini)
        $token = Str::random(60);
        $customer->api_token = $token;
        $customer->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => $customer,
            'token' => $token, // ← pakai token yang disimpan
        ], 200);
    }
    public function deposit(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Create deposit request
        $depositRequest = DepositRequest::create([
            'customer_id' => Auth::id(), // pastikan user sudah login
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => DepositRequest::PENDING, // Status awal adalah pending
        ]);

        return response()->json(['status' => 'success', 'message' => 'Permintaan deposit berhasil dikirim', 'data' => $depositRequest], 201);
    }
    
}
