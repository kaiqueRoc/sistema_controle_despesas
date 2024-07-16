<?php
namespace App\Http\Services\Auth;

use App\Http\Services\Auth\Interface\ILogin;
use Exception;

class LoginService implements ILogin
{
    public function login(array $credentials): array
    {
        if (!$token = auth()->setTTL(6 * 60)->attempt($credentials)) {
            throw new Exception('Not authorized', 401);
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => auth()->user(),
        ];
    }
}