<?php

namespace App\Http\Repository;

use App\Models\DataNilai;
use App\Models\Mahasiswa;

class MahasiswaRepository
{
    public static function index()
    {
        $mahasiswa = Mahasiswa::with('user')->get();

        return $mahasiswa;
    }
    public static function nilai($request)
    {
        $filter = [];
        $request->matkul_id ? $filter['matkul_id'] = $request->matkul_id : null;
        $request->dosen_id ? $filter['dosen_id'] = $request->dosen_id : null;
        if ($request->jurusan) {
            $nilai = DataNilai::where($filter)->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('jurusan', 'like', '%' . $request->jurusan . '%');
            })->with('mahasiswa', 'matkul', 'dosen')->get();
        } else {
            $nilai = DataNilai::where($filter)->with('mahasiswa', 'matkul', 'dosen')->get();
        }

        return $nilai;
    }
}
