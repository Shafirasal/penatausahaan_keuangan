<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 't_rekening';
    protected $primaryKey = 'id_rekening';
    // public $incrementing = true;
    public $timestamps = true;

    // Kolom yang bisa diisi
    protected $fillable = [
        'kode_rekening',
        'id_program',
        'id_kegiatan',
        'id_sub_kegiatan',
        'nama_rekening',
    ];

    //Relasi ke master program
 
    public function program()
    {
        return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
    }

    //Relasi ke master kegiatan

    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
    }

   //Relasi ke master sub kegiatan
   
    public function subKegiatan()
    {
        return $this->belongsTo(MasterSubKegiatanModel::class, 'id_sub_kegiatan', 'id_sub_kegiatan');
    }

    public function ssh()
    {
        return $this->hasMany(SshModel::class, 'id_rekening', 'id_rekening');
    }
}
