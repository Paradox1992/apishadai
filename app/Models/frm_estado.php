<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class frm_estado extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
    ];

    public function formulario()
    {
        return $this->hasMany(formularios::class, 'id');
    }
}