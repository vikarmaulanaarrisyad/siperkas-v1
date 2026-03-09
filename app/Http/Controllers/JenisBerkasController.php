<?php

namespace App\Http\Controllers;

use App\Models\JenisBerkas;
use App\Services\JenisBerkasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisBerkasController extends Controller
{
    protected $service;

    public function __construct(JenisBerkasService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.jenis_berkas.index');
    }

    public function data()
    {
        $jenisBerkas = $this->service->getAll();

        return datatables($jenisBerkas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($q) {
                return '
                <button onclick="editForm(`' . route('admin.jenis-berkas.show', $q->id) . '`)" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('admin.jenis-berkas.destroy', $q->id) . '`, `' . $q->nama_berkas . '`)" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
        $validator = Validator::make($request->all(), [
            'kode_berkas' => 'required',
            'nama_berkas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $this->service->store($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->service->find($id);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_berkas' => 'required',
            'nama_berkas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $this->service->update($id, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
