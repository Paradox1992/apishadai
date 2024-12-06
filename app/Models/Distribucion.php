<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribucion extends Model
{
    use HasFactory;

    protected  $table = 'distribucion';

    protected $fillable = [
        'id',
        'proveedor',
        'lote',
        'precio',
        'costo',
        'isv',
        'valor_isv',
        'dto',
        'dto_extra',
        'valor_dto',
        'valor_dto_extra',
    ];

    public function Proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor');
    }


    public function Lote()
    {
        return $this->belongsTo(Lotes::class, 'lote');
    }
}
