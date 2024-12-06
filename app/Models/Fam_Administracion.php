<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam_Administracion extends Model
{
    use HasFactory;

    protected $table = 'fam_administracion';

    protected $fillable = [
        'descripcion',
    ];

    public function Familia()
    {
        return $this->hasMany(Familia::class);
    }
}