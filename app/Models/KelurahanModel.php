<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelurahanModel extends Model
{
    use HasFactory;

    protected $table = 't_kelurahan';
    protected $primaryKey = 'id_kelurahan';
    public $timestamps = false;

    protected $fillable = ['id_kecamatan', 'nama_kelurahan'];

    // Relasi: Kelurahan milik Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(KecamatanModel::class, 'id_kecamatan', 'id_kecamatan');
    }

    // Relasi tidak langsung: bisa akses provinsi lewat kecamatan
    public function provinsi()
    {
        return $this->hasOneThrough(
            ProvinsiModel::class,
            KecamatanModel::class,
            'id_kecamatan', // foreign key di kecamatan
            'id_provinsi',  // foreign key di provinsi
            'id_kecamatan', // local key di kelurahan
            'id_provinsi'   // local key di kecamatan
        );
    }
}
