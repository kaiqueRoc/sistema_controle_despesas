<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateUserRequest;
use App\Http\Services\Factories\User\MakeUserService;

class UserController extends Controller
{

    private $makeUserService;

    public function __construct()
    {
        $this->makeUserService = new MakeUserService();
    }
    /**
     * @OA\Get(
     *   tags={"Users"},
     *   path="/users",
     *   summary="Busca todos os usuários",
     *   description="Buscar todos os usuários cadastrados",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *   )
     * )
     */
    public function index()
    {
        $users = $this->makeUserService->makeUserService()->findAll();
        return response()->json(['status' => true, 'users' => $users], 200);
    }

    /**
     * @OA\Post(
     *   tags={"Users"},
     *   path="/users",
     *   summary="Cadastra um novo usuário",
     *   description="Cadastrar usuário",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="email", type="string"),
     *       @OA\Property(property="password", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created",
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Content",
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *   )
     * )
     */
    public function store(CreateOrUpdateUserRequest $request)
    {
        $user = $this->makeUserService->makeUserService()->create($request);
        return response()->json(['status' => true, 'user' => $user], 201);
    }

    /**
     * @OA\Get(
     *   tags={"Users"},
     *   path="/users/{id}",
     *   summary="Busca usuário pelo id",
     *   description="Buscar usuário cadastrado pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id do usuário",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *   )
     * )
     */
    public function show(int $id)
    {
        $user = $this->makeUserService->makeUserService()->findById($id);
        return response()->json(['status' => true, 'user' => $user], 200);
    }

    /**
     * @OA\Put(
     *   tags={"Users"},
     *   path="/users/{id}",
     *   summary="Altera usuário pelo id",
     *   description="Alterar usuário pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id do usuário",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="email", type="string"),
     *       @OA\Property(property="password", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created",
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Content",
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *   )
     * )
     */
    public function update(CreateOrUpdateUserRequest $request, int $id)
    {
        $user = $this->makeUserService->makeUserService()->update($request, $id);
        return response()->json(['status' => true, 'user' => $user], 201);
    }

     /**
     * @OA\Delete(
     *   tags={"Users"},
     *   path="/users/{id}",
     *   summary="Deleta usuário pelo id",
     *   description="Deletar usuário pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id do usuário",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *   )
     * )
     */
    public function destroy(int $id)
    {
        $this->makeUserService->makeUserService()->delete($id);
        return response()->json(['status' => true], 200);
    }
}
