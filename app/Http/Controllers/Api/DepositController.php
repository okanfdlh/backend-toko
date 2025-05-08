<?php
    
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositRequestController extends Controller
{
    // Menyimpan permintaan deposit
    public function store(Request $request)
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
