<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $fillable = [
        'usuario',
        'modulo',
        'vista',
    ];


    public function Usuario(){
        return $this->belongsTo(User::class, 'usuario');
    }
    public function Modulo()    {
        return $this->belongsTo(Modulos::class, 'modulo');
    }

    public function Vista()    {
        return $this->belongsTo(Vistas::class, 'vista');
    }

}
