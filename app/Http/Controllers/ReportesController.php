<?php

namespace App\Http\Controllers;

use App\Services\ReportesService;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    protected $service;

    public function __construct(ReportesService $service)
    {
        $this->service = $service;
    }

    /**
     * PASO 1: Solicita a Python una URL firmada de S3.
     * El Frontend usará esta URL para subir el archivo directamente a AWS.
     */
    public function generarUrlSubida(Request $request)
    {
        // [MODIFICADO] Validamos que llegue el file_size
        $request->validate([
            'filename' => 'required|string',
            'content_type' => 'required|string',
            'file_size' => 'required|integer' 
        ]);

        // [MODIFICADO] Pasamos el file_size al servicio
        $res = $this->service->generarUrlSubida(
            $request->filename, 
            $request->content_type,
            $request->file_size
        );
        return response()->json($res);
    }

    /**
     * PASO 2: Una vez el archivo está en S3, este método le avisa a Python
     * que debe comenzar a procesarlo (Worker).
     */
  public function iniciarProcesamiento(Request $request)
    {
        $request->validate([
            'file_key' => 'required|string',
            'empresa' => 'required|string'
        ]);

        $res = $this->service->iniciarProcesamiento($request->file_key, $request->empresa);
        return response()->json($res);
    }

    /**
     * OPCIONAL: Consultar el reporte activo actual.
     */
    public function getActivo()
    {
        try {
            $data = $this->service->getReporteActivo();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}