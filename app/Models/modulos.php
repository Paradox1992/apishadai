<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modulos extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'estado',
    ];


    public function estado()
    {
        return $this->belongsTo(modulo_estado::class, 'estado');
    }

    public function formulario()
    {
        return $this->hasMany(formularios::class, 'id');
    }

    public function permiso()
    {
        return $this->hasMany(permisos::class, 'modulo');
    }
}