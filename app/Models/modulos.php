<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function Estado()
    {
        return $this->belongsTo(ModuloEstados::class, 'estado');
    }

    public function Vista()
    {
        return $this->hasMany(Vistas::class);
    }
    
    public function Permisos(){
        return $this->hasMany(Permisos::class);
    }
}