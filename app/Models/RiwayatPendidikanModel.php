<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPendidikanModel extends Model
{
    use HasFactory;
    protected $table = 't_pendidikan';
    protected $primaryKey = 'id_pendidikan';
    public $timestamps = true;

    protected $fillable = [
        'nip', 'nama_sekolah', 'tingkat', 'prodi_jurusan', 'tahun_lulus', 'aktif'
    ];

    //Relasi ke Pegawai (Many to One)
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(PegawaiModel::class, 'nip', 'nip');
    }
}
