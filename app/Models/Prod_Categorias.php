<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod_Categorias extends Model
{
    use HasFactory;
    protected $table = 'prod_categorias';
    protected $fillable = ['nombre'];


    public function Producto()
    {
        return $this->hasMany(Productos::class);
    }
}
