<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fam_Presentacion extends Model
{
    use HasFactory;

    protected $table = 'fam_presentacion';
    protected $fillable = [
        'id',
        'descripcion',
        'created_at',
        'updated_at',
    ];

    public function Familia()
    {
        return $this->hasMany(Familia::class);
    }
}