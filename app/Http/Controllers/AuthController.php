<?php
namespace App\Http\Controllers;

use App\Http\Services\Auth\Interface\ILogin;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $loginService;

    public function __construct(ILogin $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/login",
     *   summary="Realiza autenticação",
     *   description="Realizar autenticação",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="email", type="string"),
     *       @OA\Property(property="password", type="string")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $credentials = $request->only('email', 'password');
            $auth = $this->loginService->login($credentials);

            return response()->json($auth, 200);

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }
    }
}
