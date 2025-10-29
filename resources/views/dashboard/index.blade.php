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
                                        <h4>Pie Chart</h4>
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
// Data dari PHP Controller
const chartData = @json($perbandinganPerTahun);

// Persiapan data untuk Chart.js
const labels = chartData.map(item => item.tahun);
const anggaranData = chartData.map(item => item.total_anggaran);
const realisasiData = chartData.map(item => item.total_realisasi);

// Bar Chart - Anggaran vs Realisasi
var ctx2 = document.getElementById("myChart2").getContext('2d');
var myChart2 = new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Total Anggaran',
        data: anggaranData,
        backgroundColor: '#6777ef',
        borderColor: '#6777ef',
        borderWidth: 2
      },
      {
        label: 'Total Realisasi',
        data: realisasiData,
        backgroundColor: '#66bb6a',
        borderColor: '#66bb6a',
        borderWidth: 2
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    legend: {
      display: true,
      position: 'top'
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
            return 'Rp ' + value.toLocaleString('id-ID');
          }
        }
      }],
      xAxes: [{
        gridLines: {
          display: false
        }
      }]
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var label = data.datasets[tooltipItem.datasetIndex].label || '';
          if (label) {
            label += ': ';
          }
          label += 'Rp ' + tooltipItem.yLabel.toLocaleString('id-ID');
          return label;
        }
      }
    }
  }
});
</script>
@endpush