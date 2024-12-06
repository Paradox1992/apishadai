<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;
    protected $table = 'familia';
    protected $fillable = [
        'presentacion',
        'descripcion',
    ];


    public function Presentacion()
    {
        return $this->belongsTo(Fam_Presentacion::class, 'presentacion');
    }
    public function Administracion()
    {
        return $this->belongsTo(Fam_Administracion::class, 'administracion');
    }

    public function Producto()
    {
        return $this->hasMany(Productos::class, 'familia');
    }
}
