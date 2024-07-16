<?php
namespace App\Http\Services\Factories\Expense;

use App\Http\Repositories\Expense\ExpenseRepository;
use App\Http\Repositories\Users\UserRepository;
use App\Http\Services\Expense\ExpenseService;

class MakeExpenseService
{
    public function makeExpenseService()
    {
        $expenseRepository = new ExpenseRepository();
        $userRepository = new UserRepository();
        $expenseService = new ExpenseService($expenseRepository, $userRepository);

        return $expenseService;
    }
}
