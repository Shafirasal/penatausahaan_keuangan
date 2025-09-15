<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 't_transaksional_realisasi_anggaran';
    protected $primaryKey = 'id_transaksional_realisasi';
    // public $incrementing = true;
    public $timestamps = true;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_program',
        'id_kegiatan',
        'id_sub_kegiatan',
        'id_rekening',
        'id_ssh',
        'jenis_realisasi',
        'no_dokumen',
        'nilai_realisasi',
        'tanggal_realisasi',
        'file'
    ];

        protected $casts = [
        'tanggal_realisasi' => 'date',
        'nilai_realisasi'   => 'decimal:2',
    ];
    // Relasi ke master program

    public function program()
    {
        return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
    }

    //Relasi ke master kegiatan

    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
    }

    // Relasi ke master sub kegiatan

    public function sub_kegiatan()
    {
        return $this->belongsTo(MasterSubKegiatanModel::class, 'id_sub_kegiatan', 'id_sub_kegiatan');
    }

    // Relasi ke rekening

    public function rekening()
    {
        return $this->belongsTo(RekeningModel::class, 'id_rekening', 'id_rekening');
    }

    public function ssh()
    {
        return $this->belongsTo(SshModel::class, 'id_ssh', 'id_ssh');
    }

    public function scopeFilterTahun($query, $tahun = null)
    {
        $tahun = $tahun ?? now()->year; // default tahun sekarang
        return $query->whereYear('tahun', $tahun);
    }
}
