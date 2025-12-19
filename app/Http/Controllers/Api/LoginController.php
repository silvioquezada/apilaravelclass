<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JWTService;
use App\Repositories\UsuarioRepository;

class LoginController extends Controller
{
    protected $usuarioRepo;

    public function __construct(UsuarioRepository $usuarioRepo)
    {
        $this->usuarioRepo = $usuarioRepo;
    }

    public function login(Request $request, JWTService $jwt)
    {
        $registro = $this->usuarioRepo->acceder($request->usuario, $request->password);

        if ($registro!=null) {
            
            $token = $jwt->crearToken([
                'usuario' => $request->usuario
            ]);

            //$decodificado = $jwt->validarToken($token);

            return response()->json([
                'estado' => 1,
                'token' => $token
                //'decodificado' => $decodificado
            ]);
        }

        return response()->json([
            'estado' => 0,
            'mensaje' => 'Credenciales incorrectas'
        ], 200);
    }
}
