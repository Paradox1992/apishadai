<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloEstados extends Model
{
    use HasFactory;

    protected $table = 'modulo_estados';
    protected $fillable = ['descripcion'];



    public function Modulo()
    {
        return $this->hasMany(Modulos::class);
    }
}