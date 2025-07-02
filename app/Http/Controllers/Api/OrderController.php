<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Ambil data produk
        $rawProducts = $request->input('products');

        // Jika dikirim sebagai string JSON, ubah ke array
        if (is_string($rawProducts)) {
            $rawProducts = json_decode($rawProducts, true);
        }

        // Validasi data utama
        $request->validate([
            'id_customer' => 'required|integer|exists:customers,id',
            'transaction_time' => 'required|date',
            'alamat' => 'required|string',
            'total_item' => 'required|integer|min:1',
            'total' => 'required|numeric|min:1',
        ]);

        // Validasi produk
        if (empty($rawProducts) || !is_array($rawProducts)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak boleh kosong.',
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Simpan bukti pembayaran jika ada
            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            // Buat order baru
            $order = Order::create([
                'id_customer' => $request->id_customer,
                'transaction_time' => $request->transaction_time,
                'alamat' => $request->alamat,
                'bukti_pembayaran' => $buktiPath,
                'total_item' => $request->total_item,
                 'total' => $request->total,
                'status' => $request->status ?? 'pending', // default pending jika tidak dikirim
            ]);

            foreach ($rawProducts as $product) {
                $productModel = Product::find($product['id_product']);

                if (!$productModel) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Produk dengan ID {$product['id_product']} tidak ditemukan.",
                    ], 400);
                }

                // CAST ke integer sebelum perbandingan
                $requestedQty = (int) $product['quantity'];
                $availableStock = (int) $productModel->stock;

                if ($availableStock < $requestedQty) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stok produk '{$productModel->name}' tidak mencukupi.",
                    ], 400);
                }

                // Kurangi stok
                $productModel->stock -= $requestedQty;
                $productModel->save();

                // Simpan item order
                OrderItem::create([
                    'id_order' => $order->id,
                    'id_product' => $product['id_product'],
                    'quantity' => $requestedQty,
                    'price' => $product['price'],
                    'total' => $requestedQty * $product['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order berhasil dibuat!',
                'data' => $order->load('orderItems.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id_customer)
    {
        $orders = Order::with(['orderItems.product'])
                    ->where('id_customer', $id_customer)
                    ->orderBy('created_at', 'desc')
                    ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $order->status = $request->input('status');
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status order berhasil diperbarui',
            'data' => $order
        ], 200);
    }
}
