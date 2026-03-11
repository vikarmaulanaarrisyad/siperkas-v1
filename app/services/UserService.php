<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->repository->store($data);
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function resetPassword($id)
    {
        $password = Str::random(8);

        $this->repository->update($id, [
            'password' => Hash::make($password)
        ]);

        return $password;
    }
}
