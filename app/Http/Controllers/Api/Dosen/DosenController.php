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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

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
        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:mahasiswas,nim',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return BaseResponses::status(417, null, $validator->errors());
        }
        DB::beginTransaction();
        try {
            $response = NilaiRepository::store($request);
            DB::commit();
            return BaseResponses::status(200, $response, 'Nilai berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollback();
            return BaseResponses::status(500, $th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $nilai = DataNilai::find($request->id);
        if ($nilai->dosen_id == Auth::user()->id) {
            $nilai->delete();
            return BaseResponses::status(200, null, 'Nilai berhasil dihapus');
        } else {
            return BaseResponses::status(401, null, 'Anda tidak memiliki akses');
        }
    }

    public function importMahasiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        if ($validator->fails()) {
            return BaseResponses::status(417, null, $validator->errors());
        }
        DB::beginTransaction();
        try {

            $file = $request->file('file');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('import_mahasiswa', $nama_file);
            Excel::import(new MahasiswaImport, public_path('/import_mahasiswa/' . $nama_file));

            DB::commit();
            return BaseResponses::status(200, null, 'Data Mahasiswa Berhasil Diimport');
        } catch (\Throwable $th) {
            DB::rollback();
            return BaseResponses::status(500, null, $th->getMessage());
        }
    }
}
