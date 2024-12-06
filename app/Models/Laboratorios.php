<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorios extends Model
{
    use HasFactory;
    protected $table = 'laboratorios';

    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'imagen',
    ];

    public function Producto()
    {
        return $this->hasMany(Productos::class);
    }
}
