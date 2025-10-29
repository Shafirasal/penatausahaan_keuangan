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
                                            10
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
                                            <h4>Sisa Anggaran</h4>
                                        </div>
                                        <div class="card-body">
                                            42
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
                                            1,201
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
                        </div>

                    </div> {{-- card-body --}}
                </div>
            </div>
        </div>
    </section>
@endsection
