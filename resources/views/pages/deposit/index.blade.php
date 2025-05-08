@extends('layouts.app')

@section('title', 'Deposit')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Deposit Requests</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Deposit Requests</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="card">
                    <div class="card-header">
                        <h4>All Deposit Requests</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Proof</th>
                                        <th>Requested At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($deposit as $item)
                                        <tr>
                                            <td>{{ $item->customer->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                            <td>{{ $item->note ?? '-' }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $item->status === 'approved' ? 'badge-success' : 
                                                       ($item->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $item->proof ?? '-' }}</td>
                                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <form action="{{ route('deposit.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group">
                                                        <select name="status" class="form-control">
                                                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="approved" {{ $item->status === 'approved' ? 'selected' : '' }}>Approve</option>
                                                            <option value="rejected" {{ $item->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No deposit requests found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination if needed --}}
                        {{-- <div class="float-right">
                            {{ $deposit->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
