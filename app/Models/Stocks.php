<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    // table name
    protected $table = 'stocks';
    protected $fillable = [
        'descripcion',
        'direccion',
        'telefono',
    ];
    public function device()
    {
        return $this->hasMany(Devices::class);
    }
}