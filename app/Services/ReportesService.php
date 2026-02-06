<?php

namespace App\Services;

class ReportesService extends BasePythonService
{
    /**
     * Obtiene el job_id del reporte activo actualmente.
     */
    public function getReporteActivo()
    {
        return $this->get('reportes/activo');
    }

    /**
     * Solicita una URL firmada a Python para subir un archivo.
     */
    public function generarUrlSubida($filename, $contentType, $fileSize)
    {
        return $this->post('reportes/generar-url-subida', [
            'filename' => $filename,
            'content_type' => $contentType,
            'file_size' => $fileSize
        ]);
    }

    /**
     * Inicia el worker de procesamiento en Python.
     */
    public function iniciarProcesamiento($fileKey, $empresa)
    {
        return $this->post('reportes/iniciar-procesamiento', [
            'file_key' => $fileKey,
            'empresa' => $empresa
        ]);
    }

    /**
     * Obtiene los JSON pre-calculados (cartera, seguimientos, novedades).
     */
    public function getContenidoGrafico($jobId, $modulo)
    {
        if (empty($jobId) || empty($modulo)) {
            throw new \Exception("El ID del reporte y el módulo son obligatorios.");
        }
        
        return $this->get("reportes/contenido/{$jobId}/{$modulo}");
    }
    public function buscar(array $payload)
    {
        return $this->post('busquedas/filtrar-tabla-detalle', $payload);
    }
}