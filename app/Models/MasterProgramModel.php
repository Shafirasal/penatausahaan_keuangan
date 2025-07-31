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

    // Apakah primary key auto increment
    public $incrementing = true;

    // Tipe data primary key
    protected $keyType = 'int';

    // Aktifkan timestamp
    public $timestamps = true;

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'kode_program',
        'nama_program',
    ];
}
