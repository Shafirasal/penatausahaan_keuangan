<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SshModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 't_ssh';
    protected $primaryKey = 'id_ssh';
    // public $incrementing = true;
    public $timestamps = true;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'kode_ssh',
        'id_program',
        'id_kegiatan',
        'id_sub_kegiatan',
        'id_rekening',
        'nama_ssh',
        'pagu',
        'periode',
        'tahun',
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
    
    public function subKegiatan()
    {
        return $this->belongsTo(MasterSubKegiatanModel::class, 'id_sub_kegiatan', 'id_sub_kegiatan');
    }

// Relasi ke rekening
 
    public function rekening()
    {
        return $this->belongsTo(RekeningModel::class, 'id_rekening', 'id_rekening');
    }
}
