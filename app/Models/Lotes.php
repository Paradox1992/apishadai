<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    use HasFactory;

    protected $table = "lotes";

    protected $fillable = [
        'producto',
        'lote',
        'create',
        'exp'
    ];

    public function Producto()
    {
        return $this->belongsTo(Productos::class, 'producto');
    }
    public function Distribucion()
    {
        return $this->hasMany(Distribucion::class, 'lote');
    }
}
