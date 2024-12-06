<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vistas extends Model
{
    use HasFactory;
    protected $table = 'vistas';
    protected $fillable = [
        'modulo',
        'nombre',
        'estado'
    ];


    public function Estado()
    {
        return $this->belongsTo(VistaEstados::class, 'estado');
    }

    public function Modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo');
    }

    public function Permisos(){
        return $this->hasMany(Permisos::class);
    }

  
}