<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest; // [Punto 4]
use App\Services\SsoService;       // [Punto 2]
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    protected $ssoService;

    /**
     * Inyección de dependencias para la lógica de negocio [Punto 2]
     */
    public function __construct(SsoService $ssoService)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->ssoService = $ssoService;
    }

    /**
     * Login usando FormRequest para validación [Punto 4].
     */
    public function login(LoginRequest $request)
    {
        // La validación ya pasó automáticamente al inyectar LoginRequest.
        // Obtenemos solo los datos validados y seguros.
        $credentials = $request->only(['email', 'password']);

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
   /**
     * SSO para Mesa de Ayuda
     * Refactorizado para usar el servicio y evitar duplicación [Punto 3]
     */
    public function generateSsoUrl()
    {
        return $this->handleSsoGeneration(
            'http://helpdesk.electrocreditosdelcauca.com/sso-login.php',
            3600 // 1 hora
        );
    }

    /**
     * SSO para Inventario
     * Reutiliza la misma lógica a través del método privado auxiliar [Punto 3]
     */
    public function generateInventorySsoUrl()
    {
        return $this->handleSsoGeneration(
            'https://activosfijos.electrocreditosdelcauca.com/sso_login.php',
            300 // 5 minutos
        );
    }

    /**
     * Método auxiliar privado para orquestar la llamada al servicio.
     * Esto limpia los métodos públicos y centraliza el manejo de respuestas HTTP.
     */
    private function handleSsoGeneration(string $url, int $expiry)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
             return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        try {
            // [Punto 2 y 3] Delegamos la lógica compleja al servicio
            // Pasamos solo los datos variables (URL, claims específicos, tiempo)
            $ssoUrl = $this->ssoService->generateSsoLink(
                $user, 
                $url, 
                ['cedula' => $user->number_document], // Claim personalizado
                $expiry
            );

            return response()->json(['sso_url' => $ssoUrl]);

        } catch (Exception $e) {
            // [Punto 5] Capturamos la excepción del servicio y devolvemos un error 500 controlado
            // No le mostramos el error real al usuario, pero ya fue guardado en el Log por el servicio.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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