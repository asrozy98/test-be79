<?php

namespace App\Http\Repository;

use App\Models\DataNilai;
use Illuminate\Support\Facades\Auth;

class NilaiRepository
{
    public static function index()
    {
        $nilai = DataNilai::where('dosen_id', Auth::user()->id)->with('dosen', 'matkul', 'mahasiswa')->get();

        return $nilai;
    }

    public static function store($request)
    {
        $nilai = DataNilai::create([
            'nim' => $request->nim,
            'matkul_id' => $request->matkul_id,
            'dosen_id' => Auth::user()->id,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return $nilai;
    }
}
