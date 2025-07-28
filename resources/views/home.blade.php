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
            <h1>Profil Pegawai</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list ?? []])
        </div>

        <div class="section-body">

            {{-- BIODATA --}}
            <div class="card mb-4">
                <div class="card-header" style="background-color:#ffc000;">
                    <h4>Biodata Pegawai</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('storage/foto_profile/default_pp.jpg') }}"
                                class="img-fluid rounded-circle mb-3" style="max-width:150px">
                        </div>
                        <div class="col-md-9">
                            <dl class="row">
                                <dt class="col-sm-4">NIP</dt>
                                <dd class="col-sm-8">{{ $pegawai->nip }}</dd>

                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">
                                    {{ trim(($pegawai->gelar_depan ? $pegawai->gelar_depan . ' ' : '') . $pegawai->nama . ($pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '')) }}
                                </dd>

                                <dt class="col-sm-4">Tempat Lahir</dt>
                                <dd class="col-sm-8">{{ $pegawai->tempat_lahir }}</dd>

                                <dt class="col-sm-4">Tanggal Lahir</dt>
                                <dd class="col-sm-8">{{ $pegawai->tanggal_lahir }}</dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">{{ $pegawai->jenis_kelamin }}</dd>

                                <dt class="col-sm-4">Nomor HP</dt>
                                <dd class="col-sm-8">{{ $pegawai->hp }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $pegawai->email }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">{{ $pegawai->alamat }}</dd>

                                <dt class="col-sm-4">Provinsi</dt>
                                <dd class="col-sm-8">{{ $pegawai->provinsi->nama_provinsi }}</dd>

                                <dt class="col-sm-4">Kabupaten/Kota</dt>
                                <dd class="col-sm-8">{{ $pegawai->kabupatenKota->nama_kabupaten_kota }}</dd>

                                <dt class="col-sm-4">Kecamatan</dt>
                                <dd class="col-sm-8">{{ $pegawai->kecamatan->nama_kecamatan }}</dd>

                                <dt class="col-sm-4">Kelurahan/Desa</dt>
                                <dd class="col-sm-8">{{ $pegawai->kelurahan->nama_kelurahan }}</dd>

                                <dt class="col-sm-4">RT</dt>
                                <dd class="col-sm-8">{{ $pegawai->rt }}</dd>

                                <dt class="col-sm-4">RW</dt>
                                <dd class="col-sm-8">{{ $pegawai->rw }}</dd>

                                <dt class="col-sm-4">Kode Pos</dt>
                                <dd class="col-sm-8">{{ $pegawai->kode_pos }}</dd>

                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">{{ $pegawai->agama }}</dd>

                                <dt class="col-sm-4">Status Kepegawaian</dt>
                                <dd class="col-sm-8">{{ $pegawai->status_kepegawaian }}</dd>




                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIWAYAT PENDIDIKAN --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4>Riwayat Pendidikan</h4>
                </div>
                <div class="card-body">
                    @if (!empty($riwayatPendidikan) && count($riwayatPendidikan))
                        <ul class="list-group">
                            @foreach ($riwayatPendidikan as $edu)
                                <li class="list-group-item">
                                    <strong>{{ $edu->tingkat }} </strong> - {{ $edu->nama_sekolah }} -
                                    {{ $edu->prodi_jurusan }}

                                    ({{ date('Y', strtotime($edu->tahun_lulus)) }})

                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada data pendidikan.</p>
                    @endif
                </div>
            </div>

            {{-- JABATAN FUNGSIONAL --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4>Jabatan Fungsional</h4>
                </div>
                <div class="card-body">
                    @if (!empty($jabatanFungsional) && count($jabatanFungsional))
                        <ul class="list-group">
                            @foreach ($jabatanFungsional as $jf)
                                <li class="list-group-item">
                                    {{ $jf->nama_jabatan }} - {{ $jf->instansi }} <br>
                                    <small>TMT: {{ $jf->tmt_jabatan }} | Status Fungsional: {{ $jf->status_fungsional }}
                                        | Status Diklat: {{ $jf->status_diklat }}</small>
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada data jabatan fungsional.</p>
                    @endif
                </div>
            </div>

            {{-- JABATAN STRUKTURAL --}}
            <div class="card mb-4">
                <div class="card-header" style="background-color:#ffc000;">
                    <h4>Jabatan Struktural</h4>
                </div>
                <div class="card-body">
                    @if (!empty($jabatanStruktural) && count($jabatanStruktural))
                        <ul class="list-group">
                            @foreach ($jabatanStruktural as $js)
                                <li class="list-group-item">
                                    {{ $js->nama_jabatan }} - {{ $js->unitKerja->nama_unit_kerja }} <br>
                                    <small>TMT: {{ $js->tmt_jabatan }} | Jenis Pelantikan: {{ $js->jenis_pelantikan }}
                                        | Status Jabatan: {{ $js->status_jabatan }}</small>
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada data jabatan struktural.</p>
                    @endif
                </div>
            </div>

            {{-- RIWAYAT KEPEGAWAIAN --}}
            <div class="card mb-4">
                <div class="card-header" style="background-color:#7f7f7f; color:white;">
                    <h4>Riwayat Kepegawaian</h4>
                </div>
                <div class="card-body">
                    @if (!empty($riwayatKepegawaian) && count($riwayatKepegawaian))
                        <ul class="list-group">
                            @foreach ($riwayatKepegawaian as $rk)
                                <li class="list-group-item">
                                    Golongan: {{ $rk->golongan->nama_golongan }} - Jenis Kenaikan Pangkat:
                                    {{ $rk->jenisKenaikanPangkat->nama_jenis }} <br>
                                    <small>TMT Pangkat: {{ $rk->tmt_pangkat }} | Keterangan: {{ $rk->keterangan }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada riwayat kepegawaian.</p>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endsection
