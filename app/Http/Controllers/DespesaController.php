<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateDespesaRequest;
use App\Http\Services\Factories\Despesa\MakeDespesaService;

class DespesaController extends Controller
{

    private $makeDespesaService;

    public function __construct()
    {
        $this->makeDespesaService = new MakeDespesaService();
    }

    /**
     * @OA\Get(
     *   tags={"Despesas"},
     *   path="/despesas",
     *   summary="Busca todas as despesas",
     *   description="Buscar todas as despesas cadastradas",
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
        $despesas = $this->makeDespesaService->makeDespesaService()->findAll();
        return response()->json(['status' => true, 'data' => $despesas], 200);
    }

    /**
     * @OA\Post(
     *   tags={"Despesas"},
     *   path="/despesas",
     *   summary="Cadastra uma nova despesa",
     *   description="Cadastrar despesa",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="descricao", type="string"),
     *       @OA\Property(property="data", type="date"),
     *       @OA\Property(property="valor", type="number"),
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
    public function store(CreateOrUpdateDespesaRequest $request)
    {
        $despesa = $this->makeDespesaService->makeDespesaService()->create($request);
        return response()->json(['status' => true, 'data' => $despesa], 201);
    }

    /**
     * @OA\Get(
     *   tags={"Despesas"},
     *   path="/despesas/{id}",
     *   summary="Busca despesa pelo id",
     *   description="Buscar depesa cadastrada pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id da despesa",
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
        $despesa = $this->makeDespesaService->makeDespesaService()->findById($id);
        return response()->json(['status' => true, 'data' => $despesa], 200);
    }

    /**
     * @OA\Put(
     *   tags={"Despesas"},
     *   path="/despesas/{id}",
     *   summary="Altera despesa pelo id",
     *   description="Alterar despesa pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id da despesa",
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
     *       @OA\Property(property="descricao", type="string"),
     *       @OA\Property(property="data", type="date"),
     *       @OA\Property(property="valor", type="number"),
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
    public function update(CreateOrUpdateDespesaRequest $request, int $id)
    {
        $despesa = $this->makeDespesaService->makeDespesaService()->update($request, $id);
        return response()->json(['status' => true, 'data' => $despesa], 201);
    }

    /**
     * @OA\Delete(
     *   tags={"Despesas"},
     *   path="/despesas/{id}",
     *   summary="Deleta despesa pelo id",
     *   description="Deletar despesa pelo id",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     description="Id da despesa",
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
        $this->makeDespesaService->makeDespesaService()->delete($id);
        return response()->json(['status' => true, 'message' => 'Registro removido com sucesso!'], 200);
    }
}
