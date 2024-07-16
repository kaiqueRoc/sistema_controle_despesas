<?php
namespace App\Http\Services\Despesa;

use App\Http\Repositories\Despesas\Interface\IDespesaRepository;
use App\Http\Repositories\Users\Interface\IUserRepository;
use App\Http\Requests\CreateOrUpdateDespesaRequest;
use App\Http\Resources\DespesaResource;
use App\Models\Despesa;
use App\Notifications\UserNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;

class DespesaService
{
    use AuthorizesRequests;

    private $despesaRepository;
    private $userRepository;

    public function __construct(IDespesaRepository $despesaRepository, IUserRepository $userRepository)
    {
        $this->despesaRepository = $despesaRepository;
        $this->userRepository = $userRepository;
    }

    public function create(CreateOrUpdateDespesaRequest $request)
    {
        $despesa = new Despesa();
        $despesa->descricao = $request->get('descricao');
        $despesa->data = $request->get('data');
        $despesa->valor = $request->get('valor');
        $despesa->user_id = auth()->user()->id;
        $this->despesaRepository->persist($despesa);

        $user = $this->userRepository->findById($despesa->user_id);
        Notification::send($user, new UserNotification($despesa));

        return new DespesaResource($despesa);
    }

    public function findAll()
    {
        $despesas = $this->despesaRepository->findAll();
        return DespesaResource::collection($despesas);        
    }

    public function findById(int $id)
    {
        $despesa = $this->despesaRepository->findById($id);
        $this->authorize('findById', $despesa);

        return new DespesaResource($despesa);
    }

    public function update(CreateOrUpdateDespesaRequest $request, int $id)
    {
        $despesa = $this->despesaRepository->findById($id);
        $this->authorize('findById', $despesa);

        $despesa->descricao = $request->get('descricao');
        $despesa->data = $request->get('data');
        $despesa->valor = $request->get('valor');
        $this->despesaRepository->persist($despesa);

        return new DespesaResource($despesa);
    }

    public function delete(int $id)
    {
        $despesa = $this->despesaRepository->findById($id);
        $this->authorize('findById', $despesa);
        $this->despesaRepository->delete($despesa);
    }
}