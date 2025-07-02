<!-- resources/views/order/show.blade.php -->
@extends('layouts.app')

@section('title', 'Order Details')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Details</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">Order Details</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order #{{ $order->id }}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Transaction Time</th>
                                        <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer ID</th>
                                        <td>{{ $order->id_customer }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Item</th>
                                        <td>{{ $order->total_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $order->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Proof</th>
                                        <td>
                                            @if($order->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank">View Payment Proof</a>
                                            @else
                                                No proof available
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <h4>Order Items</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total ditambah ongkir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $orderItem)
                                            <tr>
                                                <td>{{ $orderItem->product->name }}</td>
                                                <td>{{ $orderItem->quantity }}</td>
                                                <td>{{ number_format($orderItem->price, 2) }}</td>
                                                <td>
                                                    @php
                                                        $total = 0;
                                                        if (isset($order->orderItems)) {
                                                            $total = $order->orderItems->sum(function ($item) {
                                                                return $item->quantity * $item->price;
                                                            });
                                                        }

                                                        $ongkir = 5000 + max(0, ($order->total_item - 1) * 2000);
                                                        $totalBayar = $total + $ongkir;
                                                    @endphp
                                                    Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
