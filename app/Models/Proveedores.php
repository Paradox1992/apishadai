<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'imagen'
    ];

    public function Distribucion()
    {
        return $this->hasMany(Distribucion::class, 'proveedor');
    }
}
