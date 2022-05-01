<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Receives auth params and returns a JWT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // método auth retorna o token de autorização
        $token = auth('api')->attempt($request->all(['email', 'password']));

        if ($token) { // usuário autenticado com sucesso
            return response()->json(['token' => $token]);
        } else { // usuário ou senha inválidos
            return response()->json(['erro' => 'Usuário ou senha inválidos'], 403);
        }
    }

    public function logout()
    {
        return 'logout';
    }

    public function refresh()
    {
        return 'refresh';
    }

    /**
     * Returns Auth user
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
