<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Para la gestión de archivos

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::query()->get(); 
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos. 'image_path' se valida como un archivo opcional.
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación de imagen
            'published_at' => 'required|date',
        ]);
        
        $data = $request->except('image_path');
        
        // Manejo de la subida de imagen
        if ($request->hasFile('image_path')) {
            // Guardar la imagen en storage/app/public/news_images y obtener la ruta
            $data['image_path'] = $request->file('image_path')->store('public/news_images');
            // Opcional: para usar Storage::url() debes cambiar 'public/' por 'storage/' en la BD
            // $data['image_path'] = str_replace('public/', 'storage/', $data['image_path']);
        }

        $new = News::create($data);

        return response()->json($new, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $new = News::findOrFail($id);
        return response()->json($new);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación de imagen opcional
            'published_at' => 'required|date',
        ]);
        
        $new = News::find($id);
        if (!$new) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $data = $request->except('image_path');

        // Manejo de la actualización de la imagen
        if ($request->hasFile('image_path')) {
            // 1. Eliminar la imagen anterior si existe
            if ($new->image_path) {
                Storage::delete($new->image_path); 
            }
            // 2. Guardar la nueva imagen
            $data['image_path'] = $request->file('image_path')->store('public/news_images');
        }

        $new->update($data);

        return response()->json($new, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $new = News::find($id);
        if (!$new) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
        
        // Eliminar el archivo de imagen asociado antes de eliminar el registro
        if ($new->image_path) {
            Storage::delete($new->image_path);
        }
        
        $new->delete();
        
        return response()->json(['message' => 'Noticia eliminada'], 204);
    }
}