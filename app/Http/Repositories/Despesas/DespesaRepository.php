<?php
namespace App\Http\Repositories\Despesas;

use App\Http\Repositories\Despesas\Interface\IDespesaRepository;
use App\Models\Despesa;

class DespesaRepository implements IDespesaRepository
{
    public function persist(Despesa $despesa): Despesa
    {
        $despesa->save();
        return $despesa;
    }

    public function findById(int $id)
    {
        return Despesa::find($id);
    }

    public function delete(Despesa $despesa)
    {
        $despesa->delete();
    }

    public function findAll(): object
    {
        return Despesa::all()->where('user_id', auth()->user()->id);
    }
}