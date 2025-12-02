<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image_path', 'published_at'];
    
    // Agregamos este atributo al JSON de respuesta
    protected $appends = ['image_url'];

    // Este 'Accessor' crea el campo mágico 'image_url'
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            // Convierte 'public/...' a una URL completa 'http://.../storage/...'
            return url(Storage::url($this->image_path));
        }
        return null; // O una URL de imagen por defecto
    }
}
