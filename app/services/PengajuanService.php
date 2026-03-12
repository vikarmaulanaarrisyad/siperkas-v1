<?php

namespace App\Services;

use App\Repositories\PengajuanRepository;
use Illuminate\Support\Facades\Auth;

class PengajuanService
{
    protected $repository;

    public function __construct(PengajuanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Ambil semua data
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Simpan data pengajuan
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    /**
     * Detail pengajuan
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update pengajuan
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Hapus pengajuan
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Pengajuan diterima
     */
    public function approve($id)
    {
        return $this->repository->update($id, [
            'status' => 'disetujui  ',
            'verified_by' => Auth::id()
        ]);
    }

    /**
     * Pengajuan ditolak
     */
    public function reject($id, $catatan = null)
    {
        return $this->repository->update($id, [
            'status' => 'ditolak',
            'keterangan' => $catatan,
            'verified_by' => Auth::id()
        ]);
    }
}
