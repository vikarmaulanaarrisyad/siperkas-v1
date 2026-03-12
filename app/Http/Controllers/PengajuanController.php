<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PengajuanService;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    protected $service;

    public function __construct(PengajuanService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pengajuan.index');
    }

    public function data(Request $request)
    {
        $query = $this->service->getAll();

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER TANGGAL DARI
        if ($request->filled('dari')) {
            $query->where('tanggal_pengajuan', '>=', $request->dari);
        }

        // FILTER TANGGAL SAMPAI
        if ($request->filled('sampai')) {
            $query->where('tanggal_pengajuan', '<=', $request->sampai);
        }

        return datatables($query)

            ->addIndexColumn()

            ->editColumn('jenis_berkas', function ($q) {

                $kode = optional($q->jenisBerkas)->kode_berkas ?? '-';
                $nama = optional($q->jenisBerkas)->nama_berkas ?? 'Tidak diketahui';

                return '
                <div>
                    <span class="badge badge-primary">' . $kode . '</span>
                    <div class="mt-1 font-weight-bold">' . $nama . '</div>
                </div>
            ';
            })

            ->addColumn('file', function ($q) {

                if (!$q->file) {
                    return '<span class="text-muted">Tidak ada file</span>';
                }

                $url = asset('storage/' . $q->file);
                $namaFile = basename($q->file);

                return '
                <button
                    class="btn btn-sm btn-info"
                    onclick="lihatFile(`' . $url . '`, `' . $namaFile . '`)"
                    title="Lihat File"
                >
                    <i class="fas fa-file-alt"></i> Preview
                </button>
            ';
            })

            ->addColumn('status', function ($q) {

                switch ($q->status) {

                    case 'menunggu':
                        return '<span class="badge badge-warning">Pending</span>';

                    case 'disetujui':
                        return '<span class="badge badge-success">Disetujui</span>';

                    case 'ditolak':
                        return '<span class="badge badge-danger">Ditolak</span>';

                    default:
                        return '<span class="badge badge-secondary">Unknown</span>';
                }
            })

            ->addColumn('aksi', function ($q) {

                // Jika sudah diproses
                if ($q->status !== 'menunggu') {

                    return '
                    <button
                        onclick="deleteData(`' . route('admin.pengajuan.destroy', $q->id) . '`, `Pengajuan #' . $q->id . '`)"
                        class="btn btn-sm btn-danger"
                        title="Hapus"
                    >
                        <i class="fas fa-trash-alt"></i>
                    </button>
                ';
                }

                // Jika masih pending
                return '

                <button
                    onclick="approvePengajuan(`' . route('admin.pengajuan.approve', $q->id) . '`)"
                    class="btn btn-sm btn-success"
                    title="Terima"
                >
                    <i class="fas fa-check"></i>
                </button>

                <button
                    onclick="rejectPengajuan(`' . route('admin.pengajuan.reject', $q->id) . '`)"
                    class="btn btn-sm btn-warning"
                    title="Tolak"
                >
                    <i class="fas fa-times"></i>
                </button>

                <button
                    onclick="deleteData(`' . route('admin.pengajuan.destroy', $q->id) . '`, `Pengajuan #' . $q->id . '`)"
                    class="btn btn-sm btn-danger"
                    title="Hapus"
                >
                    <i class="fas fa-trash-alt"></i>
                </button>
            ';
            })

            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengajuan' => 'required'
        ]);

        $this->service->store($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        return response()->json([
            'status' => 'success',
            'data' => $pengajuan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $this->service->update($pengajuan->id, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        $this->service->delete($pengajuan->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil dihapus'
        ]);
    }

    /**
     * Approve Pengajuan
     */
    public function approve($id)
    {
        $this->service->approve($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil diterima'
        ]);
    }

    /**
     * Reject Pengajuan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required'
        ]);

        $this->service->reject($id, $request->catatan);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil ditolak'
        ]);
    }
}
