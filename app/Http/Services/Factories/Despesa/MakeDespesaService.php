<?php
namespace App\Http\Services\Factories\Despesa;

use App\Http\Repositories\Despesas\DespesaRepository;
use App\Http\Repositories\Users\UserRepository;
use App\Http\Services\Despesa\DespesaService;

class MakeDespesaService
{
    public function makeDespesaService()
    {
        $despesaRepository = new DespesaRepository();
        $userRepository = new UserRepository();
        $despesaService = new DespesaService($despesaRepository, $userRepository);

        return $despesaService;
    }
}