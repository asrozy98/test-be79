<?php

namespace App\Http\Resources\Nilai;

use Illuminate\Http\Resources\Json\JsonResource;

class AverageResource extends JsonResource
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
            'mahasiswa_id' => $this->user_id,
            'nim' => $this->nim,
            'nama' => $this->nama,
            'jurusan' => $this->jurusan,
            'total_nilai' => $this->nilai->sum('nilai'),
            'jumlah_matkul' => $this->nilai->count(),
            'rata_rata' => round($this->nilai->avg('nilai')),
        ];
    }
}
