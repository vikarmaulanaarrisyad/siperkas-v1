<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::latest()->get();
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function store(array $data)
    {
        $user = User::create($data);

        $user->assignRole('admin');

        return $user;
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
