<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($periode) }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan - {{ ucfirst($periode) }}<br>
    Tanggal: {{ $tanggal->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Waktu</th>
                <th>Total Item</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Detail Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $order)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d/m/Y H:i') }}</td>
                <td>{{ $order->total_item }}</td>
                <td>Rp {{ number_format($order->orderItems->sum('total'), 0, ',', '.') }}</td>
                <td>{{ $order->payment_method ?? '-' }}</td>
                <td>
                    <ul>
                        @foreach($order->orderItems as $item)
                        <li>{{ $item->product->name ?? 'Produk Dihapus' }} ({{ $item->quantity }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
