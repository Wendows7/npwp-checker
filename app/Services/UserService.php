<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->latest();
    }

    public function deleteById($request)
    {
        return $this->user->where('id', $request->id)->delete();
    }

    public function addUser($validateData)
    {
        return $this->user->create($validateData);
    }

    public function checkDuplicateUser($email)
    {
        $check = $this->user->where('email', $email)->first();

        if ($check) {
            return true;
        }else
        {
            return false;
        }
    }

    public function editById($id, $data)
    {
        return $this->user->where('id', $id)->update($data);
    }

    public function getUserById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }
}
