<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\Regional;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource (Todos los Centros de Costo).
     */
    public function index()
    {
        $costCenters = CostCenter::with('regional')->get();
        return response()->json($costCenters);
    }

    /**
     * Store a newly created CostCenter linked to a specific Regional ID (Ruta Anidada).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regional  $regional
     */

    /**
     * Store a newly created resource (Requiere regional_id en el cuerpo).
     */
    public function store(Request $request)
    {
        $request->validate([
            // Validamos que el ID sea único y requerido
            'id' => 'required|unique:cost_centers,id', 
            'cost_center_name' => 'required|string|max:255',
            'regional_id' => 'required|exists:regionals,id',
        ]);

        // Al usar create con $request->all(), ahora funcionará porque 'id' y 'regional_id' están en el $fillable del modelo
        $costCenter = CostCenter::create($request->all());

        return response()->json($costCenter->load('regional'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $costCenter = CostCenter::with('regional')->findOrFail($id);
        return response()->json($costCenter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $costCenter = CostCenter::findOrFail($id);

        $request->validate([
            'cost_center_name' => 'required|string|max:255',
            'regional_id' => 'required|exists:regionals,id',
        ]);

        // No actualizamos el ID en el update para mantener la integridad, solo nombre y regional
        $costCenter->update([
            'cost_center_name' => $request->cost_center_name,
            'regional_id' => $request->regional_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $costCenter = CostCenter::findOrFail($id);
        $costCenter->delete();

        return response()->json(['message' => 'Centro de Costo eliminado'], 204);
    }
}