<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanFungsionalModel extends Model
{
    use HasFactory;

    protected $table = 't_jabatan_fungsional';
    protected $primaryKey = 'id_jabatan_fungsional';
    public $timestamps = true;

    protected $fillable = [
        'id_jabatan_fungsional',
        'nip',
        'nama_jabatan',
        'instansi',
        'tmt_jabatan',
        'PAK',
        'status_fungsional',
        'status_diklat',
        'aktif'
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'nip', 'nip');
    }
}
