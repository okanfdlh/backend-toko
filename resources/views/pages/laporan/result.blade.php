@extends('layouts.app')

@section('title', 'Hasil Laporan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Laporan {{ ucfirst($periode) }} - {{ $tanggal->format('d M Y') }}</h1>
            <div class="section-header-button">
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="section-body">
            @if($orders->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu Transaksi</th>
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
                            <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d M Y H:i') }}</td>
                            <td>{{ $order->total_item }}</td>
                            <td>Rp {{ number_format($order->orderItems->sum('total'), 0, ',', '.') }}</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td>
                                <ul class="mb-0 pl-3">
                                    @foreach($order->orderItems as $item)
                                    <li>{{ $item->product->name ?? 'Produk Dihapus' }} ({{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                Tidak ada data untuk periode ini.
            </div>
            @endif
        </div>
    </section>
</div>
@endsection
