<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'telefono',
        'ubicacion',
    ];


    public function Device()
    {
        return $this->hasMany(Devices::class);
    }
}