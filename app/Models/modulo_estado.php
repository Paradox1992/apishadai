<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modulo_estado extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
    ];


    public function modulos()
    {
        return $this->hasMany(modulos::class, 'id');
    }
}
