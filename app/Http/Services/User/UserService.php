<?php
namespace App\Http\Services\User;

use App\Http\Repositories\Users\Interface\IUserRepository;
use App\Http\Requests\CreateOrUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserService
{
    use AuthorizesRequests;

    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateOrUpdateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        $this->repository->persist($user);

        return new UserResource($user);
    }

    public function findAll()
    {
        $users = $this->repository->findAll();
        return UserResource::collection($users);
    }

    public function findById(int $id)
    {
        $user = $this->repository->findById($id);
        return new UserResource($user);
    }

    public function update(CreateOrUpdateUserRequest $request, int $id)
    {
        $user = $this->repository->findById($id);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        $this->repository->persist($user);

        return new UserResource($user); 
    }

    public function delete(int $id)
    {
        $user = $this->repository->findById($id);
        $this->repository->delete($user);
    }
}