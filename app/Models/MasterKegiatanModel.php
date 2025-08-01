<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class MasterKegiatanModel extends Model
// {
//     use HasFactory;

//     // Nama tabel di database
//     protected $table = 't_master_kegiatan';

//     // Primary key
//     protected $primaryKey = 'id_kegiatan';
//     // public $incrementing = true;
//     public $timestamps = true;


//     protected $fillable = [
//         'kode_kegiatan',
//         'id_program',
//         'nama_kegiatan',
//     ];

//     /**
//      * Relasi ke tabel master program (many to one).
//      */
//     public function program()
//     {
//         return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
//     }

//         public function subKegiatan()
//     {
//         return $this->hasMany(MasterSubKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
//     }


//     public function rekening()
//     {
//         return $this->hasMany(RekeningModel::class, 'id_kegiatan', 'id_kegiatan');
//     }

//     public function ssh()
//     {
//         return $this->hasMany(SshModel::class, 'id_kegiatan', 'id_kegiatan');
//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatanModel extends Model
{
    use HasFactory;

    protected $table = 't_master_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    
    // Primary key adalah auto increment, jadi biarkan default
    public $incrementing = true;
    protected $keyType = 'int';
    
    public $timestamps = true;

    protected $fillable = [
        'kode_kegiatan',
        'id_program',
        'nama_kegiatan',
    ];

    // Cast untuk optimasi
    protected $casts = [
        'id_kegiatan' => 'integer',
        'id_program' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel master program (many to one)
     */
    public function program()
    {
        return $this->belongsTo(MasterProgramModel::class, 'id_program', 'id_program');
    }

    /**
     * Relasi ke tabel master sub kegiatan (one to many)
     */
    public function subKegiatan()
    {
        return $this->hasMany(MasterSubKegiatanModel::class, 'id_kegiatan', 'id_kegiatan');
    }

    /**
     * Relasi ke tabel rekening (one to many)
     */
    public function rekening()
    {
        return $this->hasMany(RekeningModel::class, 'id_kegiatan', 'id_kegiatan');
    }

    /**
     * Relasi ke tabel SSH (one to many)
     */
    public function ssh()
    {
        return $this->hasMany(SshModel::class, 'id_kegiatan', 'id_kegiatan');
    }

    // Scope untuk pencarian
    public function scopeByKode($query, $kode)
    {
        return $query->where('kode_kegiatan', $kode);
    }

    public function scopeByProgram($query, $idProgram)
    {
        return $query->where('id_program', $idProgram);
    }

    // Accessor untuk menampilkan kode dan nama
    public function getKodeNamaAttribute()
    {
        return $this->kode_kegiatan . ' - ' . $this->nama_kegiatan;
    }

    // Validation rules (opsional, bisa digunakan di FormRequest)
    public static function rules()
    {
        return [
            'kode_kegiatan' => 'required|string|max:8|unique:t_master_kegiatan,kode_kegiatan',
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'nama_kegiatan' => 'required|string|max:200',
        ];
    }
}
