<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formularios extends Model
{
    use HasFactory;

    protected $fillable = [
        'modulo',
        'descripcion',
        'estado',
    ];

    public function estado()
    {
        return $this->belongsTo(frm_estado::class, 'estado');
    }

    public function modulo()
    {
        return $this->belongsTo(modulos::class, 'id');
    }

    public function permiso()
    {
        return $this->hasMany(permisos::class, 'formulario');
    }
}
