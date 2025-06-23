@extends('layouts.app')

@section('title', 'Profil Toko')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profil Toko</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item active">Profil Toko</div>
            </div>
        </div>

        <div class="section-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form method="POST" action="{{ url('/store-profile') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Form Profil Toko</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Nama Pemilik</label>
                                    <input type="text" name="owner_name" class="form-control"
                                        value="{{ old('owner_name', $profile->owner_name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="store_name" class="form-control"
                                        value="{{ old('store_name', $profile->store_name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control">{{ old('address', $profile->address ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>QRIS (Upload Gambar)</label>
                                    <input type="file" name="logo" class="form-control-file">
                                    @if ($profile && $profile->logo_url)
                                        <small class="form-text text-muted mt-2">QRIS saat ini:</small>
                                        <img src="{{ asset('storage/logo/'.$profile->logo_url) }}" alt="QRIS" class="img-thumbnail mt-2" style="max-height: 150px;">
                                    @endif
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>

                    @if ($profile && $profile->logo_url)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>Preview QRIS</h4>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/logo/'.$profile->logo_url) }}" alt="QRIS" class="img-fluid rounded shadow" style="max-height: 250px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
