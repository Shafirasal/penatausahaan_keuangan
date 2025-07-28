<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecamatanModel extends Model
{
    use HasFactory;

    protected $table = 't_kecamatan';
    protected $primaryKey = 'id_kecamatan';
    public $timestamps = false;

    protected $fillable = ['id_kabupaten_kota', 'nama_kecamatan'];

    // Relasi: Kecamatan milik Kabupaten/Kota
    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKotaModel::class, 'id_kabupaten_kota', 'id_kabupaten_kota');
    }

    // Relasi: 1 Kecamatan punya banyak Kelurahan
    public function kelurahan()
    {
        return $this->hasMany(KelurahanModel::class, 'id_kecamatan', 'id_kecamatan');
    }
}
