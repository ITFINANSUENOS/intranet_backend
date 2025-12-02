<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_event', 
        'description_event', 
        'event_date',
        // No se incluye image_path aquí porque el campo está en la tabla News, no Events.
    ];
}
