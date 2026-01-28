<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Exception;
use Illuminate\Support\Facades\Log;

class SsoService
{
    /**
     * Genera una URL de SSO con un token JWT firmado.
     *
     * @param User $user El usuario autenticado.
     * @param string $baseUrl La URL base del sistema destino.
     * @param array $customClaims Datos específicos para el payload (ej. cédula).
     * @param int $expirationTime Tiempo de expiración en segundos.
     * @return string La URL completa con el token.
     * @throws Exception Si falla la configuración o la generación del token.
     */
    public function generateSsoLink(User $user, string $baseUrl, array $customClaims = [], int $expirationTime = 3600): string
    {
        // 1. Seguridad Crítica: Verificación estricta de la clave secreta [Punto 1]
        $secretKey = env('JWT_SECRET');
        
        if (empty($secretKey)) {
            // Logueamos el error interno para los desarrolladores
            Log::critical('SSO Error: JWT_SECRET no está configurado en el archivo .env.');
            // Lanzamos una excepción genérica para no exponer detalles al cliente
            throw new Exception('Error de configuración del servidor (SSO Key missing).');
        }

        // 2. Manejo de Errores: Bloque Try-Catch para la generación del token [Punto 5]
        try {
            $issuedAt = time();
            $expire = $issuedAt + $expirationTime;

            // Construcción del Payload base + Claims personalizados [Punto 3 - DRY]
            $payload = [
                'iss' => config('app.url'),
                'iat' => $issuedAt,
                'exp' => $expire,
                'data' => array_merge([
                    'id' => $user->id,
                    'email' => $user->email,
                ], $customClaims)
            ];

            // Codificación
            $token = JWT::encode($payload, $secretKey, 'HS256');

            // Retorno de URL
            return $baseUrl . '?token=' . urlencode($token);

        } catch (Exception $e) {
            Log::error("Error generando token SSO para usuario {$user->id}: " . $e->getMessage());
            throw new Exception('No se pudo generar el enlace de acceso seguro.');
        }
    }
}