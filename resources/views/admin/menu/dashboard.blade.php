@extends('admin.layouts.admin-app')

@section('title', 'Admin | Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container">
        <h3>Admin Dashboard</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Pengguna</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.menu.users') }}" class="text-white">{{ $userCount }}</a>
                        </h5>
                        <p class="card-text">Jumlah Total Pengguna.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Pesanan Masuk</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.bookings.today') }}" class="text-white">{{ $todayBookingsCount }}</a>
                        </h5>
                        <p class="card-text">Transaksi Pesanan.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">Grafik Pemasukan</div>
                    <div class="card-body">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">Grafik Kepuasan Pelanggan</div>
                    <div class="card-body">
                        <canvas id="satisfactionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Income Chart
        var incomeCtx = document.getElementById('incomeChart').getContext('2d');
        var incomeChart = new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: @json($incomeLabels), // Array of labels (e.g., ['January', 'February', ...])
                datasets: [{
                    label: 'Pemasukan',
                    data: @json($incomeData), // Array of income data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            }
        });

        // Satisfaction Chart
        var satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        var satisfactionChart = new Chart(satisfactionCtx, {
            type: 'bar',
            data: {
                labels: ['Kurang Baik', 'Baik', 'Sangat Baik'],
                datasets: [{
                    label: 'Kepuasan Pelanggan',
                    data: @json($satisfactionData), // Array of satisfaction levels (e.g., [10, 20, 30])
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
