<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinsiModel extends Model
{
    use HasFactory;

    protected $table = 't_provinsi';
    protected $primaryKey = 'id_provinsi';
    public $timestamps = false;

    protected $fillable = ['nama_provinsi'];

    // Relasi: Satu provinsi punya banyak kecamatan
    public function kabupatenKota()
    {
        return $this->hasMany(KabupatenKotaModel::class, 'id_provinsi', 'id_provinsi');
    }

}
