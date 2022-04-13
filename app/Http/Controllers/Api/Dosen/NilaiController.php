<?php

namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nilai\AverageCollection;
use App\Http\Response\BaseResponses;
use App\Models\DataNilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function average()
    {
        $mahasiswa = Mahasiswa::with('nilai')->get();
        $response = new AverageCollection($mahasiswa);

        return BaseResponses::status(200, $response);
    }

    public function averageJurusan()
    {
        $jurusan = Mahasiswa::get()->pluck('jurusan')->unique();

        $data = [];
        foreach ($jurusan as $key => $item) {
            $mahasiswa = Mahasiswa::where('jurusan', $item)->get();
            $nilai = DataNilai::whereIn('nim', [$mahasiswa->pluck('nim')])->get();
            $data[$key] = [
                'jurusan' => $item,
                'jumlah_mahasiswa' => $mahasiswa->count(),
                'jumlah_matkul' => MataKuliah::whereIn('nim', [$mahasiswa->pluck('nim')])->get()->pluck('nama_matkul')->unique()->count(),
                'jumlah_nilai' => $nilai->count(),
                'rata-rata' => $nilai->avg('nilai') ?? 0,
            ];
        }

        return BaseResponses::status(200, $data);
    }
}
