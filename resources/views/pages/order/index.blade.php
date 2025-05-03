@extends('layouts.app')

@section('title', 'Orders')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders</h1>
                <div class="section-header-button">
                    <a href="{{ route('order.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">All Orders</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('order.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Transaction Time</th>
                                                <th>Customer ID</th>
                                                <th>Total Item</th>
                                                <th>Alamat</th>
                                                <th>Bukti Pembayaran</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('Y-m-d H:i:s') }}</td>
                                                    <td>{{ $order->id_customer }}</td>
                                                    <td>{{ $order->total_item }}</td>
                                                    <td>{{ $order->alamat }}</td>
                                                    <td>
                                                        @if($order->bukti_pembayaran)
                                                            <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank">Lihat</a>
                                                        @else
                                                            Tidak ada
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="input-group">
                                                                <select name="status" class="form-control">
                                                                    <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                                    <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                                    <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-sm btn-success" type="submit"><i class="fas fa-check"></i></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href='{{ route('order.edit', $order->id) }}' class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-secondary btn-icon ml-2">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
