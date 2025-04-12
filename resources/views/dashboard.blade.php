@extends('layouts.layout')
@section('content')
@section('content')
    @if (session('error'))
        @push('scripts')
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK'
                });
            </script>
        @endpush
    @endif
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Transaksi Hari Ini</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">Rp. {{ $totalPendapatanHariIni }}</h2>
                        <p class="text-white mb-0">Jan - March 2019</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Barang Terjual</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $stokTerjual }}</h2>
                        <p class="text-white mb-0">Jan - March 2019</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-3">
                <div class="card-body">
                    <h3 class="card-title text-white">Members</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $memberCount }}</h2>
                        <p class="text-white mb-0">Jan - March 2019</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-4">
                <div class="card-body">
                    <h3 class="card-title text-white">Pengajuan Barang</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $pengajuanBarangCount }}</h2>
                        <p class="text-white mb-0">Jan - March 2019</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pb-0 d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">Product Sales</h4>
                                <p>Total Earnings of the Month</p>
                            </div>
                            <div>
                                <ul>
                                    <li class="d-inline-block mr-3"><a class="text-dark" href="#">Day</a></li>
                                    <li class="d-inline-block mr-3"><a class="text-dark" href="#">Week</a></li>
                                    <li class="d-inline-block"><a class="text-dark" href="#">Month</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="barChartTransaksi" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ url('/transaksi-harian') }}")
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('barChartTransaksi').getContext('2d');
                    const barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'Jumlah Transaksi',
                                    backgroundColor: '#5c36d3',
                                    borderColor: '#4b2fb8',
                                    borderWidth: 1,
                                    data: data.jumlah_transaksi
                                },
                                {
                                    label: 'Total Pendapatan (Rp)',
                                    backgroundColor: '#fc544b',
                                    borderColor: '#db3e35',
                                    borderWidth: 1,
                                    data: data.total_pendapatan
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    top: 10,
                                    bottom: 10,
                                    left: 10,
                                    right: 10
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#888',
                                        font: {
                                            size: 12,
                                            family: "'Poppins', sans-serif"
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#333',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    padding: 10
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: '#aaa',
                                        font: {
                                            size: 11,
                                            family: "'Poppins', sans-serif"
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#aaa',
                                        font: {
                                            size: 11,
                                            family: "'Poppins', sans-serif"
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.05)'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Gagal memuat data chart:', error));
        });
    </script>
@endpush
