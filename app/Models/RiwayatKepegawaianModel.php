<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKepegawaianModel extends Model
{
    use HasFactory;
    // Relasi ke pegawai (many → one)
public function pegawai()
{
    return $this->belongsTo(PegawaiModel::class, 'nip', 'nip');
}

// Relasi ke golongan (one → one, FK di sini)
public function golongan()
{
    return $this->belongsTo(GolonganModel::class, 'id_golongan', 'id_golongan');
}

// Relasi ke jenis kenaikan pangkat (one → one, FK di sini)
public function jenisKenaikanPangkat()
{
    return $this->belongsTo(JenisKenaikanPangkatModel::class, 'id_jenis_kp', 'id_jenis_kp');
}

}
