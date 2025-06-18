<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::paginate(5);
        return view('pages.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:8', // Ensure password is provided
            // 'saldo' => 'required|numeric|min:0',
        ]);

        // Create a new customer record
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->saldo = 0;
        $customer->password = Hash::make($request->password); // Hash the password before saving

        $customer->save();

        // Generate the Bearer token
        // $token = $customer->createToken('YourAppName')->plainTextToken;

        // // Return response with token
        // return response()->json([
        //     'message' => 'Customer successfully created',
        //     'token' => $token,
        // ], 201);
        return redirect()->route('customer.index')->with('success', 'Customer successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validasi input, saldo tidak wajib diisi
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'phone_number' => 'required',
        'saldo' => 'nullable|numeric|min:0',  // Saldo tidak wajib, jika ada, harus numeric dan >= 0
    ]);

    // Cari customer berdasarkan ID
    $customer = Customer::findOrFail($id);

    // Jika saldo ada dalam request, update saldo
    if ($request->has('saldo')) {
        $customer->saldo = $request->input('saldo');
    }

    // Update data customer lainnya
    $customer->update($request->except('saldo'));  // Jangan update saldo lagi jika sudah di-update terpisah

    return redirect()->route('customer.index')->with('success', 'Customer successfully updated');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customer.index');
    }
}
