<?php
namespace App\Http\Services\Expense;

use App\Http\Repositories\Expense\Interface\IExpenseRepository;
use App\Http\Repositories\Users\Interface\IUserRepository;
use App\Http\Requests\CreateOrUpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Notifications\UserNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;

class ExpenseService
{
    use AuthorizesRequests;

    private $expenseRepository;
    private $userRepository;

    public function __construct(IExpenseRepository $expenseRepository, IUserRepository $userRepository)
    {
        $this->expenseRepository = $expenseRepository;
        $this->userRepository = $userRepository;
    }

    public function create(CreateOrUpdateExpenseRequest $request)
    {
        $expense = new Expense();
        $expense->descricao = $request->get('descricao');
        $expense->data = $request->get('data');
        $expense->valor = $request->get('valor');
        $expense->user_id = auth()->user()->id;
        $this->expenseRepository->persist($expense);

        $user = $this->userRepository->findById($expense->user_id);
        Notification::send($user, new UserNotification($expense));

        return new ExpenseResource($expense);
    }

    public function findAll()
    {
        $expenses = $this->expenseRepository->findAll();
        return ExpenseResource::collection($expenses);
    }

    public function findById(int $id)
    {
        $expense = $this->expenseRepository->findById($id);
        $this->authorize('findById', $expense);

        return new ExpenseResource($expense);
    }

    public function update(CreateOrUpdateExpenseRequest $request, int $id)
    {
        $expense = $this->expenseRepository->findById($id);
        $this->authorize('findById', $expense);

        $expense->descricao = $request->get('descricao');
        $expense->data = $request->get('data');
        $expense->valor = $request->get('valor');
        $this->expenseRepository->persist($expense);

        return new ExpenseResource($expense);
    }

    public function delete(int $id)
    {
        $expense = $this->expenseRepository->findById($id);
        $this->authorize('findById', $expense);
        $this->expenseRepository->delete($expense);
    }
}
