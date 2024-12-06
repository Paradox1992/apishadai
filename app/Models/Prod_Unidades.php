<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod_Unidades extends Model
{
    use HasFactory;

    protected $table = 'prod_unidades';

    protected $fillable = [
        'abreviatura_c',
        'abreviatura_v',
        'cantidad_c',
        'cantidad_v'
    ];


    public function Producto()
    {
        return $this->hasMany(Productos::class);
    }
}
