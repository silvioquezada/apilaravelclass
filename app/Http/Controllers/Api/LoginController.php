<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JWTService;

class LoginController extends Controller
{
    public function login(Request $request, JWTService $jwt)
    {
        if ($request->usuario === "admin" && $request->password === "12345") {
            
            $token = $jwt->crearToken([
                'usuario' => $request->usuario
            ]);

            $decodificado = $jwt->validarToken($token);

            return response()->json([
                'token' => $token,
                'decodificado' => $decodificado
            ]);
        }

        return response()->json([
            'mensaje' => 'Credenciales incorrectas'
        ], 401);
    }
}
