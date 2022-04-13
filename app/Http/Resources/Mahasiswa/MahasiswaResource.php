<?php

namespace App\Http\Resources\Mahasiswa;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'id' => $this->user_id,
        //     'nim' => $this->nim,
        //     'nama' => $this->nama,
        //     'umur' => $this->umur(Carbon::now()->format('Y'), Carbon::parse($this->tanggal_lahir)->format('Y')),
        //     'jurusan' => $this->jurusan,
        //     'dosen' => $this->nilai->dosen->nama,
        //     'matkul' => $this->matkul->nama_matkul,
        //     'nilai' => $this->nilai->nilai,
        // ];
    }

    public function umur($yearNow, $yearBirth)
    {
        $umur = $yearNow - $yearBirth;
        return $umur;
    }
}
