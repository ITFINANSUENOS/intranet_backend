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

    public function initDashboard(Request $request, $modulo)
    {
        try {
            // 2. CORRECCIÓN: Primero intentamos tomar el ID que envía el frontend
            $jobId = $request->input('job_id');

            // Solo si el frontend NO envió nada, buscamos el activo en base de datos (fallback)
            $activo = null;
            if (!$jobId) {
                $activo = $this->reportesService->getReporteActivo(); 
                $jobId = $activo['active_job_id'] ?? $activo['job_id'] ?? null;
            }

            if (!$jobId) {
                return response()->json(['error' => 'No hay reportes procesados.'], 404);
            }

            // 3. Obtenemos los gráficos usando el ID (sea el del request o el activo)
            $graficos = $this->reportesService->getContenidoGrafico($jobId, $modulo); 
            
            return response()->json([
                'job_id' => $jobId,
                'empresa' => $activo['empresa'] ?? 'N/A', // Nota: Si viene del request, 'empresa' podría ser null aquí, pero no rompe el código
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