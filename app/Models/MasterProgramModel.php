<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProgramModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 't_master_program';

    // Primary key
    protected $primaryKey = 'id_program';
    
    public $timestamps = true;

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'kode_program',
        'nama_program',
    ];

      //Relasi ke t_master_kegiatan
    public function kegiatan()
    {
        return $this->hasMany(MasterKegiatanModel::class, 'id_program', 'id_program');
    }

    // Relasi ke t_master_sub_kegiatan
    public function subKegiatan()
    {
        return $this->hasMany(MasterSubKegiatanModel::class, 'id_program', 'id_program');
    }

    //Relasi ke t_rekening
    public function rekening()
    {
        return $this->hasMany(RekeningModel::class, 'id_program', 'id_program');
    }

    //Relasi ke t_ssh
    public function ssh()
    {
        return $this->hasMany(SshModel::class, 'id_program', 'id_program');
    }
}
