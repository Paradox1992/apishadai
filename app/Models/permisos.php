<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permisos extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario',
        'modulo',
        'formulario',
        'last_access'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function modulo()
    {
        return $this->belongsTo(modulos::class, 'id');
    }
    public function formulario()
    {
        return $this->belongsTo(formularios::class, 'id');
    }
}
