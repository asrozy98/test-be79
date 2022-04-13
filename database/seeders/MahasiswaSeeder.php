<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswa = User::factory()->has(Mahasiswa::factory()->state(new Sequence(
            ['jurusan' => 'ti'],
            ['jurusan' => 'siskom'],
            ['jurusan' => 'elektro'],
            ['jurusan' => 'hukum'],
            ['jurusan' => 'peternakan'],
        ))->count(1))->count(10)->create();
    }
}
