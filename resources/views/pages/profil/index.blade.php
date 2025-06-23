@extends('layouts.app')

@section('title', 'Profil Toko')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profil Toko</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item active">Profil</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Informasi Toko</h4>
                    <div class="card-header-action">
                        <a href="{{ route('store.profile.edit') }}" class="btn btn-warning">Edit Profil</a>
                    </div>
                </div>
                <div class="card-body">
                   @if ($profile)
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Pemilik</th>
                            <td>{{ $profile->owner_name }}</td>
                        </tr>
                        <tr>
                            <th>Nama Bank</th>
                            <td>{{ $profile->store_name }}</td>
                        </tr>
                        <tr>
                            <th>No. Rekening</th>
                            <td>{{ $profile->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $profile->address }}</td>
                        </tr>
                        <tr>
                            <th>QRIS</th>
                            <td>
                                @if ($profile->logo_url)
                                    <img src="{{ asset('storage/logo/' . $profile->logo_url) }}" alt="QRIS"
                                        class="img-thumbnail" style="max-height: 200px;">
                                @else
                                    <span class="text-muted">Belum ada QRIS</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                @else
                    <div class="alert alert-warning">
                        Profil toko belum tersedia. <a href="{{ route('store.profile.edit') }}">Klik di sini untuk menambahkan.</a>
                    </div>
                @endif

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
