<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * Saves the resource in the database
     * @param obiect $userData
     * @return App\Models\User
     */
    public function create($userData)
    {
        return $this->user::create([
            "name" => $userData->name,
            "email" => $userData->email,
            "password" => bcrypt($userData->password),
        ]);
    }

    public function update($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return $user;
    }
}
