<?php
namespace App\Http\Services\Auth\Interface;

interface ILogin
{
    public function login(array $credentials): array;
}