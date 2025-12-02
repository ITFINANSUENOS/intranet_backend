<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objectives = Objective::query()
        //->included() // Descomentar y definir si aplica
        //->filter()   // Descomentar y definir si aplica
        //->sort()     // Descomentar y definir si aplica
        ->get(); // O getOrPaginate() si tienes la lógica

        return response()->json($objectives);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos
        $request->validate([
            'title_objective' => 'required|max:255',
            'description_objective' => 'nullable',
            'start_date_objective' => 'required|date',
            'end_date_objective' => 'required|date|after_or_equal:start_date_objective',
        ]);
        
        $objective = Objective::create($request->all());

        return response()->json($objective, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $objective = Objective::findOrFail($id);
        return response()->json($objective);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_objective' => 'required|max:255',
            'description_objective' => 'nullable',
            'start_date_objective' => 'required|date',
            'end_date_objective' => 'required|date|after_or_equal:start_date_objective',
        ]);
        
        $objective = Objective::find($id);
        if (!$objective) {
            return response()->json(['message' => 'Objetivo no encontrado'], 404);
        }

        $objective->update($request->all());

        return response()->json($objective, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objective = Objective::find($id);
        if (!$objective) {
            return response()->json(['message' => 'Objetivo no encontrado'], 404);
        }
        
        $objective->delete();
        
        return response()->json(['message' => 'Objetivo eliminado'], 204);
    }
}