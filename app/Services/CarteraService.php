<?php

namespace App\Services;

class CarteraService extends BasePythonService
{
    

    /**
     * Buscador Global y Tabla Paginada.
     * Envía filtros y término de búsqueda a Python.
     */
   public function filtrarTablaDetalle(array $filtros)
    {
        // Se conecta con @router.post("/filtrar-tabla-detalle") en busquedas_route.py
        return $this->post('busquedas/filtrar-tabla-detalle', $filtros); 
    }
}