<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengajuans')->insert([
            [
                'user_id' => 3,
                'jenis_berkas_id' => 1,
                'verified_by' => 1,
                'file' => 's29a_mahasiswa1.pdf',
                'keterangan' => 'Pengajuan skripsi',
                'tanggal_pengajuan' => '2026-03-01',
                'status' => 'disetujui',
                'tanggal_verifikasi' => '2026-03-02 09:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'jenis_berkas_id' => 2,
                'verified_by' => null,
                'file' => 's25a_mahasiswa2.pdf',
                'keterangan' => 'Pengajuan seminar proposal',
                'tanggal_pengajuan' => '2026-03-03',
                'status' => 'menunggu',
                'tanggal_verifikasi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'jenis_berkas_id' => 3,
                'verified_by' => 2,
                'file' => 's30a_mahasiswa1.pdf',
                'keterangan' => 'Pengajuan sidang skripsi',
                'tanggal_pengajuan' => '2026-03-04',
                'status' => 'ditolak',
                'tanggal_verifikasi' => '2026-03-05 14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
