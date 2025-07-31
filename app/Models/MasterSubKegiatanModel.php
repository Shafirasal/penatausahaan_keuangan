<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubKegiatanModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 't_master_sub_kegiatan';
    // Primary key
    protected $primaryKey = 'id_sub_kegiatan';
    // // Auto increment
    // public $incrementing = true;
    public $timestamps = true;

    // Kolom yang bisa diisi
    protected $fillable = [
        'kode_sub_kegiatan',
        'id_program',
        'id_kegiatan',
        'nama_sub_kegiatan',
    ];

    /**
     * Relasi ke master program
     */
    public function program()
    {
        return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
    }

    /**
     * Relasi ke master kegiatan
     */
    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
    }

        /**
     * Relasi ke rekening (one-to-many)
     */
    public function rekening()
    {
        return $this->hasMany(RekeningModel::class, 'id_sub_kegiatan', 'id_sub_kegiatan');
    }

    /**
     * Relasi ke ssh (one-to-many)
     */
    public function ssh()
    {
        return $this->hasMany(SshModel::class, 'id_sub_kegiatan', 'id_sub_kegiatan');
    }
}
