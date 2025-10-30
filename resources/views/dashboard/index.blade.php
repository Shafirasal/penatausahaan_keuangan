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

                        {{-- Chart Section --}}
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Bar Chart</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Line Chart</h4>
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
</script>
@endpush