<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JabatanStrukturalModel extends Model
{
    use HasFactory;
    protected $table = 't_jabatan_struktural';
    protected $primaryKey = 'id_jabatan_stuktural';
    public $timestamps = true;

    protected $fillable = [
        'id_jabatan_stuktural', 
        'nip', 
        'nama_jabatan',
        'jenis_pelantikan',
        'id_unit_kerja', 
        'tmt_jabatan',
        'status_jabatan',
        'aktif'
    ];

    // relasi dengan table pegawai(Many To One)
    public function pegawai():BelongsTo
    {
        return $this-> belongsTo(PegawaiModel::class, 'nip', 'nip');
    }

    public function unitKerja()
{
    return $this->belongsTo(UnitKerjaModel::class, 'id_unit_kerja');
}
}
