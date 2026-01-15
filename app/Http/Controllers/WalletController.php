<?php
namespace App\Http\Controllers;

use App\Services\CarteraService;
use App\Services\ReportesService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $carteraService;
    protected $reportesService;

    public function __construct(CarteraService $cartera, ReportesService $reportes)
    {
        $this->carteraService = $cartera;
        $this->reportesService = $reportes;
    }

    public function initDashboard($modulo)
    {
        try {
            $activo = $this->reportesService->getReporteActivo(); 
            $jobId = $activo['active_job_id'] ?? $activo['job_id'] ?? null;

            if (!$jobId) {
                return response()->json(['error' => 'No hay reportes procesados.'], 404);
            }

            $graficos = $this->reportesService->getContenidoGrafico($jobId, $modulo); 
            
            return response()->json([
                'job_id' => $jobId,
                'empresa' => $activo['empresa'] ?? 'N/A',
                'data' => $graficos
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

   public function buscar(Request $request)
{
    // 1. Validamos los campos base y permitimos los arrays de filtros
    $payload = $request->validate([
        'job_id'      => 'required|string',
        'origen'      => 'required|string', // Aquí enviaremos "seguimientos_gestion" o "seguimientos_rodamientos"
        'search_term' => 'nullable|string',
        'page'        => 'integer',
        'page_size'   => 'integer',
        
        // Filtros opcionales (Arrays) para coincidir con Python
        'empresa'     => 'nullable|array',
        'regional'    => 'nullable|array',
        'zona'        => 'nullable|array',
        'franja'      => 'nullable|array',
        'estado_pago' => 'nullable|array',
        'rodamiento'  => 'nullable|array',
        // Puedes agregar aquí los demás filtros que soporte tu Python (FiltrosTabla)
    ]);

    try {
        // 2. Aseguramos valores por defecto para evitar nulls hacia Python
        $payload['page'] = $payload['page'] ?? 1;
        $payload['page_size'] = $payload['page_size'] ?? 20;
        $payload['search_term'] = $payload['search_term'] ?? "";

        // 3. Enviamos a Python
        $resultado = $this->reportesService->buscar($payload);
        
        return response()->json([
            'status' => 'success',
            'data'   => $resultado['data'] ?? [],
            'meta'   => [
                'total' => $resultado['total_registros'] ?? 0,
                'page'  => $resultado['pagina_actual'] ?? 1,
                'pages' => $resultado['total_paginas'] ?? 0
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}