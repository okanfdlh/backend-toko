<?php
    
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Deposit;
    use App\Models\StoreProfile;
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
    // Mendapatkan profil toko
    public function getStoreProfile()
    {
        $profile = StoreProfile::first();

        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profil toko tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'owner_name' => $profile->owner_name,
                'phone_number' => $profile->phone_number,
                // Pastikan ini adalah route yang bisa diakses dan mengandung header CORS
                'logo_url' => $profile->logo_url ? url('image/logo/' . $profile->logo_url) : null,
            ]
        ]);
    }



}
    
