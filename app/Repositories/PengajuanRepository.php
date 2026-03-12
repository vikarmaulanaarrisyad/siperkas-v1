<?php

namespace App\Repositories;

use App\Models\Pengajuan;

class PengajuanRepository
{

    public function getAll()
    {
        return Pengajuan::query()->with('jenisBerkas')->latest();
    }

    public function find($id)
    {
        return Pengajuan::findOrFail($id);
    }

    public function store(array $data)
    {
        return Pengajuan::create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->find($id);
        $query->update($data);

        return $query;
    }

    public function delete($id)
    {
        $query = $this->find($id);
        return $query->delete();
    }
}
