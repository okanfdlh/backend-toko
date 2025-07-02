<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(5);
        return view('pages.order.index', compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.order.create');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);
    
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
    
        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }
    public function show($id)
        {
            // Perbaiki relasi dengan menggunakan nama relasi yang benar
            $order = Order::with('orderItems.product')->findOrFail($id);

            return view('pages.order.show', compact('order'));
        }


    
//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
// {
//     $request->validate([
//         'id_customer' => 'required|integer',
//         'transaction_time' => 'required',
//         'alamat' => 'required|string',
//         'bukti_pembayaran' => 'nullable|string',
//         'total_item' => 'required|integer',
//         'products' => 'required|array', // produk yg diorder
//         'products.*.id_product' => 'required|integer',
//         'products.*.quantity' => 'required|integer|min:1',
//         'products.*.price' => 'required|numeric|min:0',
//     ]);

//     DB::beginTransaction();
//     try {
//         // Simpan Order
//         $order = Order::create([
//             'id_customer' => $request->id_customer,
//             'transaction_time' => $request->transaction_time,
//             'alamat' => $request->alamat,
//             'bukti_pembayaran' => $request->bukti_pembayaran ?? '',
//             'total_item' => $request->total_item,
//         ]);

//         // Simpan OrderItem satu-satu
//         foreach ($request->products as $product) {
//             OrderItem::create([
//                 'id_order' => $order->id,
//                 'id_product' => $product['id_product'],
//                 'quantity' => $product['quantity'],
//                 'price' => $product['price'],
//             ]);
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Order berhasil dibuat!',
//             'data' => $order->load('orderItems')
//         ], 201);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Gagal membuat order: ' . $e->getMessage()
//         ], 500);
//     }
// }

//     /**
//      * Display the specified resource.
//      */
//     public function show($id)
// {
//     $order = Order::with('orderItems')->find($id);

//     if (!$order) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Order tidak ditemukan'
//         ], 404);
//     }

//     return response()->json([
//         'status' => 'success',
//         'data' => $order
//     ], 200);
// }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
