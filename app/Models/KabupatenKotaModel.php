<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenKotaModel extends Model
{
    use HasFactory;

    protected $table = 't_kabupaten_kota';
    protected $primaryKey = 'id_kabupaten_kota';
    public $timestamps = false;

    protected $fillable = ['id_provinsi', 'nama_kabupaten_kota'];

    // Relasi: Kabupaten/Kota milik Provinsi
    public function provinsi()
    {
        return $this->belongsTo(ProvinsiModel::class, 'id_provinsi', 'id_provinsi');
    }

    // Relasi: 1 Kabupaten/Kota punya banyak Kecamatan
    public function kecamatan()
    {
        return $this->hasMany(KecamatanModel::class, 'id_kabupaten_kota', 'id_kabupaten_kota');
    }
}
