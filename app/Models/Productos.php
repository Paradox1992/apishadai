<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria',
        'laboratorio',
        'unidad',
        'familia',
        'codigo',
        'codigobar',
        'descripcion',
        'imagen',
        'estado'
    ];


    public function Categoria()
    {
        return $this->belongsTo(Prod_Categorias::class, 'categoria');
    }

    public function Laboratorio()
    {
        return $this->belongsTo(Laboratorios::class, 'laboratorio');
    }

    public function Unidad()
    {
        return $this->belongsTo(Prod_Unidades::class, 'unidad');
    }

    public function Familia()
    {
        return $this->belongsTo(Familia::class, 'familia');
    }

    public function Estado()
    {
        return $this->belongsTo(Prod_Estado::class, 'estado');
    }

    public function Lotes()
    {
        return $this->hasMany(Lotes::class);
    }
}