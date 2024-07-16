<?php
namespace App\Http\Repositories\Users;

use App\Models\User;
use App\Http\Repositories\Users\Interface\IUserRepository;

class UserRepository implements IUserRepository
{
    public function persist(User $user): User
    {
        $user->save();
        return $user;
    }

    public function findById(int $id)
    {
        return User::find($id);
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function findAll(): object
    {
        return User::all();
    }
}