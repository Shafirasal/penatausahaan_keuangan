<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PegawaiModel extends Model
{
    use HasFactory;

    protected $table = 't_pegawai'; // nama tabel
    protected $primaryKey = 'nip'; // primary key
    public $incrementing = false; // karena 'nip' bukan auto-increment
    protected $keyType = 'string'; // karena 'nip' bertipe varchar

    public $timestamps = true;

    protected $fillable = [
        'nip',
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'hp',
        'email',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'agama',
        'status_kepegawaian',
        'id_provinsi',
        'id_kabupaten_kota',
        'id_kecamatan',
        'id_kelurahan'
    ];

    // Contoh relasi jika dibutuhkan
    public function riwayatPendidikan()
    {
        return $this->hasMany(RiwayatPendidikanModel::class, 'nip', 'nip');
    }

    public function riwayatKepegawaian()
    {
    return $this->hasMany(RiwayatKepegawaianModel::class, 'nip', 'nip');
    }

}
