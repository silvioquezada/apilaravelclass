<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $request->attributes->set('jwt_user', (array) $decoded);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Token inválido',
                'msg' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
