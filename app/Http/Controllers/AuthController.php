<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Constructor para aplicar middleware.
     */
    public function __construct()
    {
        // Solo login es público
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Autentica un usuario y devuelve un token JWT.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Obtiene los datos del usuario autenticado.
     */
    public function me()
    {
        $user = auth('api')->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name_user,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * Cierra la sesión (Invalida el token).
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    /**
     * Refresca el token actual.
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * SSO para Mesa de Ayuda
     */
   public function generateSsoUrl()
    {
        $user = Auth::guard('api')->user(); // Obtiene el usuario autenticado por JWT

        if (!$user) {
             // Esto solo debería ocurrir si el middleware falló por alguna razón
             return response()->json(['message' => 'Usuario no autenticado para SSO'], 401);
        }

        // 1. Configuración de la clave secreta y reclamos
        $secretKey = env('JWT_SECRET', 'TU-CLAVE-SECRETA-SSO-MUY-LARGA'); 
        $issuerClaim = config('app.url'); 
        $audienceClaim = "electrocreditosdelcauca.com";
        $issuedAtClaim = time();
        $expireClaim = $issuedAtClaim + 3600; // 1 hora

        // 2. Definición de la Carga Útil (Payload)
        $payload = [
            'iss' => $issuerClaim,
            'aud' => $audienceClaim,
            'iat' => $issuedAtClaim,
            'exp' => $expireClaim,
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                // **Asegúrate que 'number_document' es el campo correcto para la cédula**
                'cedula' => $user->number_document 
            ]
        ];

        // 3. Codificación del Token SSO
        // Esto requiere que 'firebase/php-jwt' esté instalado
        $ssoToken = JWT::encode($payload, $secretKey, 'HS256');

        // 4. Construcción de la URL de destino
        $baseUrl = 'http://helpdesk.electrocreditosdelcauca.com/sso-login.php';
        $ssoUrl = $baseUrl . '?token=' . urlencode($ssoToken);

        // 5. Devolver la URL al frontend
        return response()->json([
            'sso_url' => $ssoUrl
        ]);
    }

    /**
     * SSO para Inventario
     */
    public function generateInventorySsoUrl()
    {
        // 1. Obtiene el usuario autenticado
        $user = Auth::guard('api')->user(); // Obtiene el usuario autenticado por JWT

        if (!$user) {
             // Si no hay usuario autenticado (lo que no debería pasar si el middleware funciona)
             return response()->json(['message' => 'Usuario no autenticado para SSO de Inventario'], 401);
        }

        // 2. Configuración (puedes ajustar estos valores si son diferentes para el sistema de inventario)
        // Se recomienda usar una clave secreta *diferente* si el sistema lo soporta, 
        // pero por simplicidad, usaremos la misma por defecto.
        $secretKey = env('JWT_SECRET', env('JWT_SECRET', 'TU-CLAVE-SECRETA-SSO-MUY-LARGA')); 
        $issuedAtClaim = time();
        $expireClaim = $issuedAtClaim + 300; // Token de corta duración: 5 minutos (ajustable)

        // 3. Definición de la Carga Útil (Payload)
        // Solo necesitamos la cédula para este sistema
        $payload = [
            'iat' => $issuedAtClaim,
            'exp' => $expireClaim,
            'data' => [
                // **Este es el campo requerido por el sistema de Inventario**
                'cedula' => $user->number_document 
            ]
        ];

        // 4. Codificación del Token SSO
        // Requiere la librería 'firebase/php-jwt'
        $ssoToken = JWT::encode($payload, $secretKey, 'HS256');

        // 5. Construcción de la URL de destino del sistema de Inventario
        // **IMPORTANTE: Debes cambiar esta URL por la URL real de tu sistema de Inventario**
        $baseUrl = 'https://activosfijos.electrocreditosdelcauca.com/sso_login.php'; 
        $ssoUrl = $baseUrl . '?token=' . urlencode($ssoToken);

        // 6. Devolver la URL al frontend
        return response()->json([
            'sso_url' => $ssoUrl
        ]);
    }

    /**
     * Estructura la respuesta del token.
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id'          => $user->id,
                'name'        => $user->name_user,
                'email'       => $user->email,
                'roles'       => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ]
        ]);
    }
}