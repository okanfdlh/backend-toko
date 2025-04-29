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
        // Validasi input
        $request->validate([
            'id_customer' => 'required|integer|exists:customers,id', // Memastikan id_customer valid
            'transaction_time' => 'required',
            'alamat' => 'required|string',
            'bukti_pembayaran' => 'nullable|image|max:2048', // Validasi file pembayaran
            'total_item' => 'required|integer',
            'products' => 'required|array', // Produk yang diorder
            'products.*.id_product' => 'required|integer|exists:products,id', // Memastikan id_product valid
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan Order
            $order = Order::create([
                'id_customer' => $request->id_customer,
                'transaction_time' => $request->transaction_time,
                'alamat' => $request->alamat,
                'bukti_pembayaran' => $request->hasFile('bukti_pembayaran')
                    ? $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public')
                    : '',
                'total_item' => $request->total_item,
            ]);

            // Simpan OrderItem satu per satu
            foreach ($request->products as $product) {
                OrderItem::create([
                    'id_order' => $order->id,
                    'id_product' => $product['id_product'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    // 'total' => $product['quantity'] * $product['price'], // Total harga per item
                ]);
            }

            DB::commit();

            // Load relasi orderItems dan kembalikan response
            return response()->json([
                'status' => 'success',
                'message' => 'Order berhasil dibuat!',
                'data' => $order->load('orderItems') // Memuat relasi orderItems
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat order: ' . $e->getMessage()
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
