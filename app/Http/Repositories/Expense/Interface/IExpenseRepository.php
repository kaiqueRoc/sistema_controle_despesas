<?php
namespace App\Http\Repositories\Expense\Interface;

use App\Models\Expense;

interface IExpenseRepository
{
    public function persist(Expense $expense): Expense;
    public function findById(int $id);
    public function findAll(): object;
    public function delete(Expense $user);
}
