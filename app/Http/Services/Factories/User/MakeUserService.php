<?php
namespace App\Http\Services\Factories\User;

use App\Http\Repositories\Users\UserRepository;
use App\Http\Services\User\UserService;

class MakeUserService
{
    public function makeUserService()
    {
        $userRepository = new UserRepository();
        $userService = new UserService($userRepository);

        return $userService;
    }
}