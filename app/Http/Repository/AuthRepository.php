<?php

namespace App\Http\Repository;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public static function registerMahasiswa($request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->segment(3),
        ]);
        $user->mahasiswa()->create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'alamat' => $request->alamat,
            'tanggal_lahir' => Carbon::parse($request->tanggal_lahir),
            'jurusan' => $request->jurusan
        ]);

        return $user;
    }

    public static function registerDosen($request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->segment(3),
        ]);
        $user->dosen()->create([
            'nama' => $request->nama,
        ]);

        return $user;
    }
}
