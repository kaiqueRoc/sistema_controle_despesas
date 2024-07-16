<?php
namespace App\Http\Repositories\Users\Interface;

use App\Models\User;

interface IUserRepository
{
    public function persist(User $user): User;
    public function findById(int $id);
    public function findAll(): object;
    public function delete(User $user);
}