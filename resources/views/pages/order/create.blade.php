@extends('layouts.app')

@section('title', 'Create Order')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h4>New Order Form</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="transaction_time">Transaction Time</label>
                                        <input type="datetime-local" name="transaction_time" id="transaction_time"
                                            class="form-control @error('transaction_time') is-invalid @enderror" 
                                            value="{{ old('transaction_time', now()->format('Y-m-d\TH:i')) }}">
                                        @error('transaction_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="id_customer">Customer ID</label>
                                        <input type="number" name="id_customer" id="id_customer"
                                            class="form-control @error('id_customer') is-invalid @enderror"
                                            value="{{ old('id_customer') }}" required>
                                        @error('id_customer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="total_item">Total Items</label>
                                        <input type="number" name="total_item" id="total_item"
                                            class="form-control @error('total_item') is-invalid @enderror"
                                            value="{{ old('total_item') }}" required>
                                        @error('total_item')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="3"
                                            class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="bukti_pembayaran">Bukti Pembayaran (Optional)</label>
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                            class="form-control-file @error('bukti_pembayaran') is-invalid @enderror">
                                        @error('bukti_pembayaran')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-right">
                                        <a href="{{ route('order.index') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Save Order</button>
                                    </div>
                                </form>
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
@endpush
