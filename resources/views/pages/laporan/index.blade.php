@extends('layouts.app')

@section('title', 'Laporan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main') {{-- Ganti ini --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan Penjualan</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('laporan.filter') }}" method="GET" class="mb-4">
                    {{-- tanggal dan periode tetap --}}
                    <input type="date" name="tanggal" class="form-control" required>
                    <select name="periode" class="form-control">
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                    {{-- Export PDF --}}
                    <a onclick="event.preventDefault(); document.getElementById('exportForm').submit();" class="btn btn-danger">
                        Export PDF
                    </a>
                </form>

                <form id="exportForm" action="{{ route('laporan.export') }}" method="GET" target="_blank" style="display:none;">
                    <input type="hidden" name="tanggal" id="exportTanggal">
                    <input type="hidden" name="periode" id="exportPeriode">
                </form>

                <script>
                    // Copy nilai input ke form export
                    document.querySelector('form').addEventListener('submit', function () {
                        document.getElementById('exportTanggal').value = document.getElementById('tanggal').value;
                        document.getElementById('exportPeriode').value = document.getElementById('periode').value;
                    });
                </script>
            </div>
        </section>
    </div>
@endsection
