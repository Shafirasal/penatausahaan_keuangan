<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerjaModel extends Model
{
    use HasFactory;

    protected $table = 't_unit_kerja';
    protected $primaryKey = 'id_unit_kerja';
    public $timestamps = false; // Karena tidak ada kolom created_at & updated_at

    protected $fillable = [
        'nama_unit_kerja',
    ];

    // Relasi ke t_jabatan_struktural
    public function jabatanStruktural()
    {
        return $this->hasMany(JabatanStrukturalModel::class, 'id_unit_kerja');
    }

    
}
