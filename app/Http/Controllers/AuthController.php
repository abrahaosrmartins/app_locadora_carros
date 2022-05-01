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
            return response()->json(['token' => $token], 200);
        } else { // usuário ou senha inválidos
            return response()->json(['erro' => 'Usuário ou senha inválidos'], 403);
        }
    }

}
