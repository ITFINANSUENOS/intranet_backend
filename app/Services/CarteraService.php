<?php

namespace App\Services;

class CarteraService extends BasePythonService
{
    public function obtenerDashboard($fileKey)
    {
        // Python espera ?file_key=... en la URL
        return $this->get('tableros/cartera/dashboard-principal', [
            'file_key' => $fileKey
        ]);
    }
}