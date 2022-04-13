<?php

namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Repository\NilaiRepository;
use App\Http\Resources\Nilai\NilaiCollection;
use App\Http\Response\BaseResponses;
use App\Models\DataNilai;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function nilai()
    {
        $data = NilaiRepository::index();
        $response = new NilaiCollection($data);

        return BaseResponses::status(200, $response);
    }

    public function nilaiStore(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'matkul' => 'required|exists:matkul,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
        ]);

        $response = NilaiRepository::store($request);

        return BaseResponses::status(200, $response, 'Nilai berhasil ditambahkan');
    }

    public function delete(DataNilai $nilai)
    {
        if ($nilai->dosen_id == Auth::user()->id) {
            $nilai->delete();
            return BaseResponses::status(200, null, 'Nilai berhasil dihapus');
        } else {
            return BaseResponses::status(401, null, 'Anda tidak memiliki akses');
        }
    }
}
