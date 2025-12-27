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

    public function     cargar(Request $request)
    {
        // 1. Validación estricta en Laravel (ahorramos viaje a Python si falla aquí)
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:50000', // Máx 50MB por ejemplo
        ]);

        try {
            // 2. Enviamos el archivo al servicio
            $resultado = $this->service->cargarReporteGeneral($request->file('file'));

            return response()->json($resultado);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}