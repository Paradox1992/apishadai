<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod_Estado extends Model
{
    use HasFactory;


    protected $table = 'prod_estado';

    protected $fillable = [
        'descripcion',
    ];

    public function Producto()
    {
        return $this->hasMany(related: Productos::class);
    }
}
