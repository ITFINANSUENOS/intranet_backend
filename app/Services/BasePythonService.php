<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class BasePythonService
{
    protected $baseUrl;
    protected $http;

    public function __construct()
    {
        // CORREGIDO: Usar config() en lugar de env()
        $this->baseUrl = config('services.python_api.url'); 

        // Aquí puedes configurar headers globales si Python llegara a pedir Token
        $this->http = Http::timeout(300) // Esperar hasta 60s si Python demora procesando     
                          ->acceptJson();
    }

    /**
     * Método genérico para peticiones GET
     */
    protected function get($endpoint, $params = [])
    {
        $urlCompleta = "{$this->baseUrl}/{$endpoint}";
        $response = $this->http->get("{$this->baseUrl}/{$endpoint}", $params);
        return $this->handleResponse($response);
    }

    /**
     * Método genérico para peticiones POST
     */
    protected function post($endpoint, $data = [])
    {
        $response = $this->http->post("{$this->baseUrl}/{$endpoint}", $data);
        return $this->handleResponse($response);
    }

    // Manejo de errores centralizado
    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        // Lanza error para que lo capture el controlador
        throw new Exception("Error Python ({$response->status()}): " . $response->body());    
    }

    protected function postMultipart($endpoint, $keyName, $file, $data = [])
    {
        // Abrimos el recurso del archivo para leerlo como stream
        $fileStream = fopen($file->getRealPath(), 'r');

        $response = $this->http->attach(
            $keyName,
            $fileStream,
            $file->getClientOriginalName()
        )->post("{$this->baseUrl}/{$endpoint}", $data);

        return $this->handleResponse($response);
    }
}
