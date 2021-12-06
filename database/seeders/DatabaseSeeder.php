<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'nama' => 'Bencana Alam',
                'slug' => 'bencana-alam',
                'deskripsi' => 'Mari bantu mereka yang kehilangan materi',
            ],
            [
                'nama' => 'Pasien',
                'slug' => 'pasien',
                'deskripsi' => 'Penyakit bukanlah hal yang mereka inginkan, mari bantu mereka'
            ],
            [
                'nama' => 'Kaum Dhuafa',
                'slug' => 'kaum-dhuafa',
                'deskripsi' => 'Berikan kebaikanmu untuk membantu mereka yang membutuhkan'
            ],
        ]);

        DB::table('pengguna')->insert([
            [
                'nama' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('admin'),
                'admin' => 1
            ]
        ]);
    }
}
