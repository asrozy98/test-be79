<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Repository\MahasiswaRepository;
use App\Http\Resources\Mahasiswa\MahasiswaCollection;
use App\Http\Resources\Nilai\NilaiAverageCollection;
use App\Http\Response\BaseResponses;
use App\Models\DataNilai;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = MahasiswaRepository::index();
        $response = new MahasiswaCollection($data);

        return BaseResponses::status(200, $response);
    }

    public function indexNilai(Request $request)
    {
        $sortBy = $request->sortBy ? $request->sortBy : null;
        $data = MahasiswaRepository::nilai($request);
        $response = new NilaiAverageCollection($data);

        return BaseResponses::status(200, $response->sortBy($sortBy));
    }
}
