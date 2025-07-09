<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKenaikanPangkatModel extends Model
{
    use HasFactory;

    protected $table = 't_jenis_kenaikan_pangkat';
    protected $primaryKey = 'id_jenis_kp';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama_jenis',
    ];

    // Jika relasi diperlukan nanti bisa ditambahkan di sini
    public function riwayatKepegawaian()
{
    return $this->belongsTo(RiwayatKepegawaianModel::class, 'id_jenis_kp', 'id_jenis_kp');
}

}
