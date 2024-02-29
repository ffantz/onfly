<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $user = User::whereEmail($request->email)->firstOrFail();

            // caso exista um usuairo cadastrado com o email informado, testa a senha
            if ($user) {
                if (Auth::attempt($request->only('email', 'password'))) {
                    $token = $user->createToken('auth_token')->plainTextToken; // cria o token de autenticacao
                    \Auth::login($user); // loga o usuario no sistema

                    // retorna o token de autenticacao da api na resposta
                    return response()->json([
                        'access_token' => $token,
                        'token_type'   => 'Bearer',
                    ]);
                }
            }

            return response()->json([
                'message' => 'Credenciais incorretas'
            ], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'O usuário ou email não está cadastrado'
            ], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        \Auth::user()->tokens()->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function me(Request $request)
    {
        return new AuthResource($request->user());
    }
}
