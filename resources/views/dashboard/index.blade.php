@extends('layouts.template')

@section('title')
    | General Dashboard
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $breadcrumb->title ?? 'General Dashboard' }}</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>General Dashboard</h4>
                    </div>

                    <div class="card-body">
                        {{-- Statistik --}}
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Anggaran</h4>
                                        </div>
                                        <div class="card-body">
                                          <h5>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-danger">
                                        <i class="far fa-newspaper"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Sisa Anggaran</h4>
                                        </div>
                                        <div class="card-body">
                                             <h5>Rp {{ number_format($totalSisa, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-warning">
                                        <i class="far fa-file"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Realisasi</h4>
                                        </div>
                                        <div class="card-body">
                                             <h5>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Anggaran PBJ</h4>
                                    </div>
                                    <div class="card-body">
                                        <h5>Rp {{ number_format($totalPBJ, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                               </div>
                        </div> --}}
                        
                        {{-- Chart Section --}}
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Perbandingan Anggaran Realisasi Sisa Perkegiatan</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tren Realisasi Per Bulan Berdasarkan Tahun</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Persentase Total Realisasi Anggaran Per Kegiatan</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>

                    </div> {{-- card-body --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')

<script>
$(document).ready(function() {
    const ctx4 = document.getElementById("myChart4");
    if (ctx4) {
        const chartData = @json($realisasiPerKegiatanProgram2);
        
        const labels = chartData.map(item => item.nama_kegiatan);
        const values = chartData.map(item => item.total_realisasi);
        const percentages = chartData.map(item => item.persentase);
        
        const colors = ['#6777ef', '#fc544b', '#ffa426', '#63ed7a', '#191d21', '#3abaf4', '#feb019', '#ff6178', '#5a8dee', '#39da8a'];
        const backgroundColor = labels.map((_, index) => colors[index % colors.length]);
        
        new Chart(ctx4.getContext('2d'), {
            type: 'pie',
            data: {
                datasets: [{
                    data: values,
                    backgroundColor: backgroundColor,
                    borderWidth: 2,
                    borderColor: '#fff'
                }],
                labels: labels
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: { position: 'bottom' },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            const currentValue = data.datasets[0].data[tooltipItem.index];
                            const percentage = percentages[tooltipItem.index];
                            const label = data.labels[tooltipItem.index];
                            const formattedValue = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(currentValue);
                            
                            return label + ': ' + formattedValue + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }
});

// const ctx2 = document.getElementById("myChart2");
//     if (ctx2) {
//         const chartData = @json($perbandinganAnggaranRealisasiSisa);
//         const labels = chartData.map(item => {
//             const namaKegiatan = item.nama_kegiatan.toLowerCase();
            
//             // 1. Cek Pembinaan 
//             if (namaKegiatan.includes('pembinaan') && namaKegiatan.includes('advokasi')) {
//                 return 'Pembinaan';
//             } 
//             // 2. Cek LPSE
//             else if (namaKegiatan.includes('lpse') || namaKegiatan.includes('layanan pengadaan secara elektronik')) {
//                 return 'LPSE';
//             } 
//             // 3. Cek PBJ 
//             else if (namaKegiatan.includes('pengadaan barang') && !namaKegiatan.includes('pembinaan')) {
//                 return 'PBJ';
//             }
            
//             // Fallback: potong nama jika terlalu panjang
//             return item.nama_kegiatan.length > 15 
//                 ? item.nama_kegiatan.substring(0, 15) + '...' 
//                 : item.nama_kegiatan;
//         });
        
//         const anggaranData = chartData.map(item => parseFloat(item.total_anggaran) || 0);
//         const realisasiData = chartData.map(item => parseFloat(item.total_realisasi) || 0);
//         const sisaData = chartData.map(item => parseFloat(item.sisa_anggaran) || 0);
        
//         new Chart(ctx2.getContext('2d'), {
//             type: 'bar',
//             data: {
//                 labels: labels,
//                 datasets: [
//                     {
//                         label: 'Anggaran',
//                         data: anggaranData,
//                         backgroundColor: '#6777ef',
//                         borderColor: '#6777ef',
//                         borderWidth: 1
//                     },
//                     {
//                         label: 'Realisasi',
//                         data: realisasiData,
//                         backgroundColor: '#ffa426',
//                         borderColor: '#ffa426',
//                         borderWidth: 1
//                     },
//                     {
//                         label: 'Sisa Anggaran',
//                         data: sisaData,
//                         backgroundColor: '#fc544b',
//                         borderColor: '#fc544b',
//                         borderWidth: 1
//                     }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: true,
//                 legend: {
//                     position: 'bottom'
//                 },
//                 scales: {
//                     yAxes: [{
//                         ticks: {
//                             beginAtZero: true,
//                             callback: function(value) {
//                                 // Format ke jutaan 
//                                 if (value >= 1000000000) {
//                                     return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
//                                 } else if (value >= 1000000) {
//                                     return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
//                                 }
//                                 return 'Rp ' + value.toLocaleString('id-ID');
//                             }
//                         },
//                         gridLines: {
//                             display: true,
//                             color: 'rgba(0,0,0,0.05)'
//                         }
//                     }],
//                     xAxes: [{
//                         gridLines: {
//                             display: false
//                         },
//                         barPercentage: 0.8,
//                         categoryPercentage: 0.9
//                     }]
//                 },
//                 tooltips: {
//                     callbacks: {
//                         label: function(tooltipItem, data) {
//                             const label = data.datasets[tooltipItem.datasetIndex].label || '';
//                             const value = tooltipItem.yLabel;
//                             const formattedValue = new Intl.NumberFormat('id-ID', {
//                                 style: 'currency',
//                                 currency: 'IDR',
//                                 minimumFractionDigits: 0
//                             }).format(value);
                            
//                             return label + ': ' + formattedValue;
//                         }
//                     }
//                 }
//             }
//         });
//     }
const ctx2 = document.getElementById("myChart2");
if (ctx2) {
    const chartData = @json($perbandinganAnggaranRealisasiSisa);
    
    // 🔹 TAMBAHKAN DATA PROGRAM 1
    const program1Data = {
        nama_kegiatan: 'Program 1',
        total_anggaran: {{ $totalAnggaranProgram1 }},
        total_realisasi: {{ $totalRealisasiProgram1 }},
        sisa_anggaran: {{ $totalSisaProgram1 }}
    };
    
    // Gabungkan dengan data yang sudah ada
    const allData = [...chartData, program1Data];
    
    const labels = allData.map(item => {
        const namaKegiatan = item.nama_kegiatan.toLowerCase();
        
        // 0. Cek Program 1
        if (namaKegiatan.includes('program 1')) {
            return 'Tatakelola';
        }
        // 1. Cek Pembinaan 
        else if (namaKegiatan.includes('pembinaan') && namaKegiatan.includes('advokasi')) {
            return 'Pembinaan';
        } 
        // 2. Cek LPSE
        else if (namaKegiatan.includes('lpse') || namaKegiatan.includes('layanan pengadaan secara elektronik')) {
            return 'LPSE';
        } 
        // 3. Cek PBJ 
        else if (namaKegiatan.includes('pengadaan barang') && !namaKegiatan.includes('pembinaan')) {
            return 'PBJ';
        }
        
        // Fallback: potong nama jika terlalu panjang
        return item.nama_kegiatan.length > 15 
            ? item.nama_kegiatan.substring(0, 15) + '...' 
            : item.nama_kegiatan;
    });
    
    const anggaranData = allData.map(item => parseFloat(item.total_anggaran) || 0);
    const realisasiData = allData.map(item => parseFloat(item.total_realisasi) || 0);
    const sisaData = allData.map(item => parseFloat(item.sisa_anggaran) || 0);
    
    new Chart(ctx2.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Anggaran',
                    data: anggaranData,
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 1
                },
                {
                    label: 'Realisasi',
                    data: realisasiData,
                    backgroundColor: '#ffa426',
                    borderColor: '#ffa426',
                    borderWidth: 1
                },
                {
                    label: 'Sisa Anggaran',
                    data: sisaData,
                    backgroundColor: '#fc544b',
                    borderColor: '#fc544b',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                position: 'bottom'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            // Format ke jutaan 
                            if (value >= 1000000000) {
                                return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
                            } else if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                            }
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    gridLines: {
                        display: true,
                        color: 'rgba(0,0,0,0.05)'
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    barPercentage: 0.8,
                    categoryPercentage: 0.9
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        const label = data.datasets[tooltipItem.datasetIndex].label || '';
                        const value = tooltipItem.yLabel;
                        const formattedValue = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(value);
                        
                        return label + ': ' + formattedValue;
                    }
                }
            }
        }
    });
}

var ctx = document.getElementById("myChart").getContext('2d');
var dataBulan = @json($trenRealisasiPerBulan);
var namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
var labels = [];
var dataRealisasi = [];
dataBulan.forEach(function(item) {
    labels.push(namaBulan[item.bulan - 1]);
    dataRealisasi.push(item.total_realisasi);
});

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Realisasi',
            data: dataRealisasi,
            borderWidth: 2,
            backgroundColor: '#6777ef',
            borderColor: '#6777ef',
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointRadius: 4,
            fill: true
        }]
    },
    options: {
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    var value = tooltipItem.yLabel;
                    // Format tooltip dengan pemisah ribuan
                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            }
        },
        scales: {
            yAxes: [{
                gridLines: {
                    drawBorder: false,
                    color: '#f2f2f2',
                },
                ticks: {
                    beginAtZero: true,
                    callback: function(value) {
                        // Format Miliar
                        if (value >= 1000000000) {
                            return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                        } 
                        // Format Juta
                        else if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                        } 
                        // Format Ribuan
                        else if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                        }
                        // Di bawah 1000
                        return 'Rp ' + value;
    }
                    // callback: function(value, index, values) {
                    //     // Format dalam jutaan (Jt)
                    //     if (value >= 1000000) {
                    //         return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                    //     }
                    //     // Format dalam ribuan (Rb)
                    //     else if (value >= 1000) {
                    //         return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                    //     }
                    //     return 'Rp ' + value;
                    // }
                }
            }],
            xAxes: [{
                ticks: {
                    display: false
                },
                gridLines: {
                    display: false
                }
            }]
        },
    }
});
</script>
@endpush