<?php
namespace App\Http\Repositories\Expense;

use App\Http\Repositories\Expense\Interface\IExpenseRepository;
use App\Models\Expense;

class ExpenseRepository implements IExpenseRepository
{
    public function persist(Expense $expense): Expense
    {
        $expense->save();
        return $expense;
    }

    public function findById(int $id)
    {
        return Expense::find($id);
    }

    public function delete(Expense $expense)
    {
        $expense->delete();
    }

    public function findAll(): object
    {
        return Expense::all()->where('user_id', auth()->user()->id);
    }
}
