@extends('layouts.template')

@section('title')
    | Home
@endsection

@section('content')
    <style>
        /* Atur agar teks header card selalu putih */
        .card-header h4 {
            color: #fff !important;
        }
    </style>
    <section class="section">
        <div class="section-header">
            <h1>Informasi Pegawai</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list ?? []])
        </div>

        <div class="section-body">

            {{-- BIODATA --}}
            <div class="card mb-4">
                <div class="card-header" style="background-color:#a93542;">
                    <h4>Biodata</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-9">
                            <dl class="row">
                                <dt class="col-sm-3">NIP</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->nip }}</dd>

                                <dt class="col-sm-3">Nama</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">
                                    {{ trim(($pegawai->gelar_depan ? $pegawai->gelar_depan . ' ' : '') . $pegawai->nama . ($pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '')) }}
                                </dd>

                                <dt class="col-sm-3">Tempat Lahir</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->tempat_lahir }}</dd>

                                <dt class="col-sm-3">Tanggal Lahir</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->tanggal_lahir }}</dd>

                                <dt class="col-sm-3">Jenis Kelamin</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->jenis_kelamin }}</dd>

                                <dt class="col-sm-3">Nomor HP</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->hp }}</dd>

                                <dt class="col-sm-3">Email</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->email }}</dd>

                                <dt class="col-sm-3">Alamat</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->alamat }}</dd>

                                <div class="col-12" style="margin-left: 2rem;">
                                    <dl class="row">
                                        <dt class="col-sm-3">Provinsi</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->provinsi->nama_provinsi }}</dd>

                                        <dt class="col-sm-3">Kabupaten/Kota</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->kabupatenKota->nama_kabupaten_kota }}</dd>

                                        <dt class="col-sm-3">Kecamatan</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->kecamatan->nama_kecamatan }}</dd>

                                        <dt class="col-sm-3">Kelurahan/Desa</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->kelurahan->nama_kelurahan }}</dd>

                                        <dt class="col-sm-3">RT</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->rt }}</dd>

                                        <dt class="col-sm-3">RW</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->rw }}</dd>

                                        <dt class="col-sm-3">Kode Pos</dt>
                                        <dt class="col-xs-1">:</dt>
                                        <dd class="col-sm-8">{{ $pegawai->kode_pos }}</dd>
                                    </dl>
                                </div>

                                <dt class="col-sm-3">Agama</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->agama }}</dd>

                                <dt class="col-sm-3">Status Kepegawaian</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">{{ $pegawai->status_kepegawaian }}</dd>



                                {{-- Riwayat Pendidikan --}}
                                <dt class="col-sm-3">Riwayat Pendidikan</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">
                                    @if (!empty($riwayatPendidikan) && count($riwayatPendidikan))
                                        @foreach ($riwayatPendidikan as $edu)
                                            <strong>{{ $edu->tingkat }}-</strong> {{ $edu->nama_sekolah }} -
                                            {{ $edu->prodi_jurusan }}
                                            ({{ date('Y', strtotime($edu->tahun_lulus)) }})
                                        @endforeach
                                    @else
                                        <p class="text-muted">Tidak ada data pendidikan.</p>
                                    @endif
                                </dd>

                                {{-- Jabatan Fungsional --}}
                                <dt class="col-sm-3">Jabatan Fungsional</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">
                                    @if (!empty($jabatanFungsional) && count($jabatanFungsional))
                                        @foreach ($jabatanFungsional as $jf)
                                            {{ $jf->nama_jabatan }} - {{ $jf->instansi }} <br>
                                            <small>TMT: {{ $jf->tmt_jabatan }} | Status Fungsional:
                                                {{ $jf->status_fungsional }}
                                                | Status Diklat: {{ $jf->status_diklat }}</small>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Tidak ada data jabatan fungsional.</p>
                                    @endif
                                </dd>

                                {{-- Jabatan Struktural --}}
                                <dt class="col-sm-3">Jabatan Struktural</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">
                                    @if (!empty($jabatanStruktural) && count($jabatanStruktural))
                                        @foreach ($jabatanStruktural as $js)
                                            {{ $js->nama_jabatan }} - {{ $js->unitKerja->nama_unit_kerja }} <br>
                                            <small>TMT: {{ $js->tmt_jabatan }} | Jenis Pelantikan:
                                                {{ $js->jenis_pelantikan }}
                                                | Status Jabatan: {{ $js->status_jabatan }}</small>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Tidak ada data jabatan struktural.</p>
                                    @endif
                                </dd>

                                {{-- Riwayat Kepegawaian --}}
                                <dt class="col-sm-3">Riwayat Kepegawaian</dt>
                                <dt class="col-xs-1">:</dt>
                                <dd class="col-sm-8">
                                    @if (!empty($riwayatKepegawaian) && count($riwayatKepegawaian))
                                        @foreach ($riwayatKepegawaian as $rk)
                                            Golongan: {{ $rk->golongan->nama_golongan }} - Jenis Kenaikan Pangkat:
                                            {{ $rk->jenisKenaikanPangkat->nama_jenis }} <br>
                                            <small>TMT Pangkat: {{ $rk->tmt_pangkat }} | Keterangan:
                                                {{ $rk->keterangan }}</small>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Tidak ada riwayat kepegawaian.</p>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-1 d-flex justify-content-center ">
                            <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('storage/foto_profile/default_pp.jpg') }}"

                                style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #ddd;">
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
