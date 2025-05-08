<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Customer;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    // Menampilkan daftar permintaan deposit
    public function index()
    {
        $deposit = Deposit::with('customer')->get();
        return view('pages.deposit.index', compact('deposit'));
    }

    // Mengubah status permintaan deposit
    public function update(Request $request, $id)
{
    $depositRequest = Deposit::findOrFail($id);

    $depositRequest->status = $request->input('status'); // 'approved' or 'rejected'
    $depositRequest->save();

    return redirect()->route('deposit.index')->with('success', 'Status permintaan deposit berhasil diperbarui');
}
}
