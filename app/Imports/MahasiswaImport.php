<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $user = new User;
        $user->email = $row['Email'];
        $user->password = Hash::make($row['Password']);
        $user->save();
        $user->mahasiswa()->create([
            'nim' => $row['NIM'],
            'nama' => $row['Nama'],
            'alamat' => $row['Alamat'],
            'jurusan' => $row['Jurusan'],
            'tanggal_lahir' => Carbon::parse($row['Tanggal Lahir']),
        ]);
        DB::commit();

        return $user;
    }
}
