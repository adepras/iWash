@extends('admin.layouts.admin-app')

@section('title', 'Admin | Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h3 class="mt-4">Dashboard</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Total Pengguna</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.menu.users') }}" class="text-black">{{ $userCount }}</a>
                        </h5>
                        <p class="card-text">Jumlah Total Pengguna.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Pesanan Masuk</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.bookings.today') }}" class="text-black">{{ $todayBookingsCount }}</a>
                        </h5>
                        <p class="card-text">Transaksi Pesanan.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-chart mb-3">
                    <div class="card-header">Grafik Pemasukan</div>
                    <div class="card-body">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-chart mb-3">
                    <div class="card-header">Grafik Kepuasan Pelanggan</div>
                    <div class="card-body">
                        <canvas id="satisfactionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Grafik Pemasukan
        var incomeCtx = document.getElementById('incomeChart').getContext('2d');
        var incomeChart = new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: @json($incomeLabels),
                datasets: [{
                    label: 'Pemasukan',
                    data: @json($incomeData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return 'Pemasukan: ' + new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });

        // Grafik Kepuasan Pelanggan
        var satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        var satisfactionChart = new Chart(satisfactionCtx, {
            type: 'bar',
            data: {
                labels: ['Kurang Baik', 'Baik', 'Sangat Baik'],
                datasets: [{
                    label: 'Kepuasan Pelanggan',
                    data: @json($satisfactionData),
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
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return 'Jumlah: ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
