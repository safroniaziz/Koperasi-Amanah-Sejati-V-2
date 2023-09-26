<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            [
                'nama_jabatan' => 'Operator',
                'created_at' => '2021-05-01 20:40:00',
                'updated_at' => '2021-05-01 20:40:00',
            ],
            [
                'nama_jabatan' => 'Anggota',
                'created_at' => '2021-12-03 00:44:00',
                'updated_at' => '2021-12-03 00:44:00',
            ],
            [
                'nama_jabatan' => 'Bendahara',
                'created_at' => '2021-12-03 00:44:00',
                'updated_at' => '2021-12-03 00:44:00',
            ],
            [
                'nama_jabatan' => 'Sekretaris',
                'created_at' => '2021-12-03 00:44:00',
                'updated_at' => '2021-12-03 00:44:00',
            ],
            [
                'nama_jabatan' => 'Pengawas',
                'created_at' => '2021-12-03 00:44:00',
                'updated_at' => '2021-12-03 00:44:00',
            ],
            [
                'nama_jabatan' => 'Ketua',
                'created_at' => '2021-12-03 00:44:00',
                'updated_at' => '2021-12-03 00:44:00',
            ],
        ];

        foreach ($jabatans as $jabatan) {
            DB::table('jabatans')->insert([
                'nama_jabatan' => $jabatan['nama_jabatan'],
                'created_at' => $jabatan['created_at'],
                'updated_at' => $jabatan['updated_at'],
            ]);
        }
    }
}
