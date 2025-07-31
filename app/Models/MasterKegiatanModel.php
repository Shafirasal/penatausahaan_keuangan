<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatanModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 't_master_kegiatan';

    // Primary key
    protected $primaryKey = 'id_kegiatan';
    // public $incrementing = true;
    public $timestamps = true;


    protected $fillable = [
        'kode_kegiatan',
        'id_program',
        'nama_kegiatan',
    ];

    /**
     * Relasi ke tabel master program (many to one).
     */
    public function program()
    {
        return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
    }

        public function subKegiatan()
    {
        return $this->hasMany(MasterSubKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
    }


    public function rekening()
    {
        return $this->hasMany(RekeningModel::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function ssh()
    {
        return $this->hasMany(SshModel::class, 'id_kegiatan', 'id_kegiatan');
    }
}
