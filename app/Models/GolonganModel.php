<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganModel extends Model
{
    use HasFactory;

    protected $table = 't_golongan';
    protected $primaryKey = 'id_golongan';
    public $timestamps = false;

    protected $fillable = [
        'nama_golongan',
    ];

    // Relasi ke Riwayat Kepegawaian (One to One dari sisi Golongan)
    public function riwayatKepegawaian()
    {
        return $this->belongsTo(RiwayatKepegawaianModel::class, 'id_golongan', 'id_golongan');
    }
}
