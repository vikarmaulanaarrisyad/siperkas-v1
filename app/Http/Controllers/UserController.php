<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function data()
    {
        $query =  $this->service->getAll();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($q) {

                $userLogin = Auth::user();

                // tidak bisa hapus diri sendiri
                if ($userLogin->id == $q->id) {
                    return '
                    <button onclick="resetPassword(`' . route('admin.users.reset-password', $q->id) . '`, `' . $q->name . '`)"
                    class="btn btn-sm btn-warning" title="Reset Password">
                    <i class="fas fa-key"></i>
                    </button>
                ';
                }

                // tidak bisa hapus user yang memiliki role admin
                if ($q->hasRole('admin')) {
                    return '
                    <button onclick="resetPassword(`' . route('admin.users.reset-password', $q->id) . '`, `' . $q->name . '`)"
                    class="btn btn-sm btn-warning" title="Reset Password">
                    <i class="fas fa-key"></i>
                    </button>
                ';
                }

                return '
                <button onclick="resetPassword(`' . route('admin.users.reset-password', $q->id) . '`, `' . $q->name . '`)"
                class="btn btn-sm btn-warning" title="Reset Password">
                <i class="fas fa-key"></i>
                </button>

                <button onclick="deleteData(`' . route('admin.users.destroy', $q->id) . '`, `' . $q->name . '`)"
                class="btn btn-sm btn-danger" title="Delete">
                <i class="fas fa-trash-alt"></i>
                </button>
            ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Input tidak valid'
            ], 422);
        }

        $this->service->store($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data pengguna berhasil disimpan'
        ], 201);
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function resetPassword($id)
    {
        $password = $this->service->resetPassword($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil direset',
            'password' => $password
        ]);
    }
}
