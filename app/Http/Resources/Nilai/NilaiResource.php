<?php

namespace App\Http\Resources\Nilai;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NilaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'mahasiswa_id' => $this->mahasiswa->user_id,
            'nim' => $this->mahasiswa->nim,
            'nama' => $this->mahasiswa->nama,
            'jurusan' => $this->mahasiswa->jurusan,
            'alamat' => $this->mahasiswa->alamat,
            'matkul' => $this->matkul->nama_matkul,
            'nilai' => $this->nilai,
        ];
    }
}
