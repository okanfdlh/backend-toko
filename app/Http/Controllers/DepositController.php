<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    // Menampilkan daftar permintaan deposit
    public function index()
    {
        $deposit = Deposit::with('customer')
            ->orderBy('created_at', 'desc') // data terbaru di atas
            ->paginate(10); // pagination 10 item per halaman

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
public function destroy($id)
{
    $deposit = Deposit::findOrFail($id);

    // Jika ada file bukti transfer, hapus dari storage
    if ($deposit->proof && Storage::exists('public/' . $deposit->proof)) {
        Storage::delete('public/' . $deposit->proof);
    }

    $deposit->delete();

    return redirect()->route('deposit.index')->with('success', 'Data deposit berhasil dihapus.');
}

}
