<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_berkas')->insert([
            [
                'kode_berkas' => 'S29A',
                'nama_berkas' => 'Pengajuan Skripsi',
                'deskripsi' => 'Berkas pengajuan skripsi mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_berkas' => 'S25A',
                'nama_berkas' => 'Pengajuan Seminar Proposal',
                'deskripsi' => 'Berkas pengajuan seminar proposal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_berkas' => 'S30A',
                'nama_berkas' => 'Pengajuan Sidang Skripsi',
                'deskripsi' => 'Berkas pengajuan sidang skripsi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_berkas' => 'S31A',
                'nama_berkas' => 'Revisi Skripsi',
                'deskripsi' => 'Berkas revisi setelah sidang skripsi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
