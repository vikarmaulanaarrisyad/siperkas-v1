<?php

namespace App\Services;

use App\Models\JenisBerkas;

class JenisBerkasService
{
    public function getAll()
    {
        return JenisBerkas::latest()->get();
    }

    public function store($data)
    {
        return JenisBerkas::create([
            'kode_berkas' => $data['kode_berkas'],
            'nama_berkas' => $data['nama_berkas'],
            'deskripsi'   => $data['deskripsi'] ?? null,
        ]);
    }

    public function update($id, $data)
    {
        $jenisBerkas = JenisBerkas::findOrFail($id);

        $jenisBerkas->update([
            'kode_berkas' => $data['kode_berkas'],
            'nama_berkas' => $data['nama_berkas'],
            'deskripsi'   => $data['deskripsi'] ?? null,
        ]);

        return $jenisBerkas;
    }

    public function delete($id)
    {
        $dataBerkas = JenisBerkas::findOrFail($id);
        return $dataBerkas->delete();
    }

    public function find($id)
    {
        return JenisBerkas::findOrFail($id);
    }
}
