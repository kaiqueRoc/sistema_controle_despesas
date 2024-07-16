<?php
namespace App\Http\Repositories\Despesas\Interface;

use App\Models\Despesa;

interface IDespesaRepository
{
    public function persist(Despesa $despesa): Despesa;
    public function findById(int $id);
    public function findAll(): object;
    public function delete(Despesa $user);
}