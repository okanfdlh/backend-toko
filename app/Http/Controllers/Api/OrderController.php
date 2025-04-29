<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input umum
    $request->validate([
        'id_customer' => 'required|integer|exists:customers,id',
        'transaction_time' => 'required',
        'alamat' => 'required|string',
        'bukti_pembayaran' => 'nullable|image|max:2048',
        'total_item' => 'required|integer',
        'products' => 'required|string',  // Mengharuskan field 'products' berupa string JSON
    ]);

    // Decode 'products' yang berupa string JSON menjadi array
    $products = json_decode($request->products, true);

    // Cek apakah produk yang didecode adalah array
    if (!is_array($products)) {
        return response()->json(['error' => 'Invalid products format'], 422);
    }

    // Validasi field produk
    foreach ($products as $product) {
        if (!isset($product['id_product'], $product['quantity'], $product['price'])) {
            return response()->json(['error' => 'Incomplete product data'], 422);
        }
    }

    DB::beginTransaction();
    try {
        // Simpan Order terlebih dahulu
        $order = Order::create([
            'id_customer' => $request->id_customer,
            'transaction_time' => $request->transaction_time,
            'alamat' => $request->alamat,
            'bukti_pembayaran' => $request->hasFile('bukti_pembayaran')
                ? $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public')
                : null,
            'total_item' => $request->total_item,
        ]);

        // Simpan setiap item produk
        foreach ($products as $product) {
            OrderItem::create([
                'id_order' => $order->id,
                'id_product' => $product['id_product'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['quantity'] * $product['price'],
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Order berhasil dibuat!',
            'data' => $order->load('orderItems'),
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal membuat order: ' . $e->getMessage(),
        ], 500);
    }
}



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }
}
