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

    /**
     * User Logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout Realizado com sucesso']);
    }

    /**
     * Refreshes the user jwt
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
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
