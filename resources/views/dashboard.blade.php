@extends('layouts.layout')
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
    <div class="container-fluid mt-3">
        <div class="row d-flex flex-wrap">
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Transaksi Hari Ini</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">Rp. {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</h2>
                            <p class="text-white mb-0">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Barang Terjual</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $stokTerjual }}</h2>
                            <p class="text-white mb-0">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Jumlah Member</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $memberCount }}</h2>
                            <p class="text-white mb-0">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
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
                                    <p>Rekap pendapatan harian dalam satu bulan terakhir</p>
                                </div>
                                {{-- <div>
                                <ul>
                                    <li class="d-inline-block mr-3"><a class="text-dark" href="#">Day</a></li>
                                    <li class="d-inline-block mr-3"><a class="text-dark" href="#">Week</a></li>
                                    <li class="d-inline-block"><a class="text-dark" href="#">Month</a></li>
                                </ul>
                            </div> --}}
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="barChartTransaksi" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
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
                                label: 'Total Pendapatan (Rp)', // Hanya dataset ini yang akan ditampilkan
                                backgroundColor: '#fc544b',
                                borderColor: '#db3e35',
                                borderWidth: 1,
                                data: data.total_pendapatan
                            }]
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
                                    suggestedMax: Math.max(...data.total_pendapatan) * 1.1,
                                    ticks: {
                                        color: '#aaa',
                                        font: {
                                            size: 11,
                                            family: "'Poppins', sans-serif"
                                        },
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString(); // Format Rupiah
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
