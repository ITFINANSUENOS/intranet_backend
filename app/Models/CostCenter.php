<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    protected $fillable = [ 'id','cost_center_name', 'regional_id'];
    public $incrementing = false;

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }
}
