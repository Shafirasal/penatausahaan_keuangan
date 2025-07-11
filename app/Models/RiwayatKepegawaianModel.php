<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKepegawaianModel extends Model
{
    use HasFactory;

    protected $table = 't_riwayat_kepegawaian';
    protected $primaryKey = 'id_riwayat_kepegawaian';
    public $timestamps = true;

    protected $fillable = [
        'nip',
        'file',
        'id_golongan',
        'id_jenis_kp',
        'tmt_pangkat',
        'keterangan',
        'aktif'
    ];

    /**
     * Relasi ke tabel pegawai (many to one)
     */
    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'nip', 'nip');
    }

    /**
     * Relasi ke tabel golongan (one to one)
     */
    public function golongan()
    {
        return $this->belongsTo(GolonganModel::class, 'id_golongan', 'id_golongan');
    }

    /**
     * Relasi ke tabel jenis kenaikan pangkat (one to one)
     */
    public function jenisKenaikanPangkat()
    {
        return $this->belongsTo(JenisKenaikanPangkatModel::class, 'id_jenis_kp', 'id_jenis_kp');
    }
}
