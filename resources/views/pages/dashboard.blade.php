@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
           
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Monthly Profit</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyProfitChart" height="182"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Best-Selling Products</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="bestSellingProductsChart" height="182"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary">Week</a>
                                    <a href="#" class="btn">Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                                    <div class="detail-value">$243</div>
                                    <div class="detail-name">Today's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                                    <div class="detail-value">$2,902</div>
                                    <div class="detail-name">This Week's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                                    <div class="detail-value">$12,821</div>
                                    <div class="detail-name">This Month's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                                    <div class="detail-value">$92,142</div>
                                    <div class="detail-name">This Year's Sales</div>
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
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
    // Monthly Profit Chart
    var monthlyProfitCtx = document.getElementById('monthlyProfitChart').getContext('2d');
    var monthlyProfitChart = new Chart(monthlyProfitCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Profit in $',
                data: @json($monthlyProfits),  // Pass the $monthlyProfits array to the chart
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Best Selling Products Chart
    var bestSellingProductsCtx = document.getElementById('bestSellingProductsChart').getContext('2d');
    var bestSellingProductsChart = new Chart(bestSellingProductsCtx, {
        type: 'bar',
        data: {
            labels: @json($bestSellingProductNames),  // Pass product names to the chart
            datasets: [{
                label: 'Sales Volume',
                data: @json($bestSellingProductSales),  // Pass sales volumes to the chart
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endpush
