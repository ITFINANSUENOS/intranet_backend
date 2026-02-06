<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\SsoService;
use App\Models\User; // <--- AGREGADO
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // <--- AGREGADO
use Exception;

class AuthController extends Controller
{
    protected $ssoService;

    public function __construct(SsoService $ssoService)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->ssoService = $ssoService;
    }

    /**
     * Login con validación granular de errores.
     */
    public function login(LoginRequest $request)
    {
        // 1. Obtenemos credenciales validadas
        $credentials = $request->only(['email', 'password']);

        // 2. Buscamos al usuario manualmente para verificar si el EMAIL existe
        $user = User::where('email', $credentials['email'])->first();

        // CASO 1: El correo no existe en la base de datos
        if (!$user) {
            return response()->json([
                'error' => 'El correo electrónico no está registrado.',
                'code'  => 'EMAIL_NOT_FOUND'
            ], 404); // Usamos 404 para indicar que no se encontró
        }

        // CASO 2: El correo existe, validamos la contraseña
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'error' => 'La contraseña es incorrecta.',
                'code'  => 'INVALID_PASSWORD'
            ], 401); // Usamos 401 para error de autenticación
        }

        // 3. Si pasa manual, generamos el token con JWT (attempt genera el token)
        if (!$token = auth('api')->login($user)) {
            return response()->json(['error' => 'Error al generar el token'], 500);
        }

        return $this->respondWithToken($token);
    }

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

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function generateSsoUrl()
    {
        return $this->handleSsoGeneration(
            'http://helpdesk.electrocreditosdelcauca.com/sso-login.php',
            3600
        );
    }

    public function generateInventorySsoUrl()
    {
        return $this->handleSsoGeneration(
            'https://activosfijos.electrocreditosdelcauca.com/sso_login.php',
            300
        );
    }

    private function handleSsoGeneration(string $url, int $expiry)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
             return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        try {
            $ssoUrl = $this->ssoService->generateSsoLink(
                $user, 
                $url, 
                ['cedula' => $user->number_document], 
                $expiry
            );
            return response()->json(['sso_url' => $ssoUrl]);
        } catch (Exception $e) {
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