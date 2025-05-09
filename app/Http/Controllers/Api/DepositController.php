<?php
    
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Deposit;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    
    class DepositController extends Controller
    {
        // Menyimpan permintaan deposit dengan bukti transfer
        public function store(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'note' => 'nullable|string',
        'proof' => 'required|file|mimes:jpg,png,pdf|max:2048', // Validasi file bukti deposit
    ]);

    // Menyimpan file bukti transfer ke storage
    $proofPath = $request->file('proof')->store('deposits', 'public');

    // Membuat deposit
    $deposit = Deposit::create([
        'customer_id' => $id, // Atau gunakan Auth::id() jika menggunakan autentikasi
        'amount' => $request->amount,
        'note' => $request->note,
        'status' => Deposit::PENDING, // Status awal deposit adalah pending
        'proof' => $proofPath, // Menyimpan path bukti file
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Deposit berhasil disimpan',
        'data' => $deposit,
    ], 201);
}
public function getDepositHistory($id)
    {
        // Mengambil semua deposit berdasarkan ID customer
        $deposits = Deposit::where('customer_id', $id)
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal deposit terbaru
            ->get();

        // Return response dengan data deposit
        return response()->json([
            'status' => 'success',
            'data' => $deposits
        ]);
    }
}
    
