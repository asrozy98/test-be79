<?php

namespace App\Http\Resources\Nilai;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NilaiAverageResource extends JsonResource
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
            'umur' => $this->umur(Carbon::now()->format('Y'), Carbon::parse($this->mahasiswa->tanggal_lahir)->format('Y')),
            'jurusan' => $this->mahasiswa->jurusan,
            'alamat' => $this->mahasiswa->alamat,
            'dosen' => $this->dosen->nama,
            'matkul' => $this->matkul->nama_matkul,
        ];
    }

    public function umur($yearNow, $yearBirth)
    {
        $umur = $yearNow - $yearBirth;
        return $umur;
    }
}
