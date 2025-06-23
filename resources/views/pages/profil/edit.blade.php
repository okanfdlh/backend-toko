@extends('layouts.app')

@section('title', 'Edit Profil Toko')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profil Toko</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('store.profile') }}">Profil</a></div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="card">
                <form method="POST" action="{{ route('store.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Form Edit Profil</h4>
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
                            <label>QRIS (Upload Baru)</label>
                            <input type="file" name="logo" class="form-control-file">
                            @if ($profile && $profile->logo_url)
                                <div class="mt-2">
                                    <small>QRIS saat ini:</small><br>
                                    <img src="{{ asset('storage/logo/'.$profile->logo_url) }}" alt="QRIS"
                                         class="img-thumbnail mt-1" style="max-height: 150px;">
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('store.profile') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
