<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // protected $table = 'mahasiswas';

    protected $fillable = [
        'nim',
        'nama',
        'alamat',
        'jurusan',
        'tanggal_lahir',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'nim', 'nim');
    }
}
