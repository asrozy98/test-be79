<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'matkul_id',
        'dosen_id',
        'nilai',
        'keterangan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nim', 'nim');
    }
}
