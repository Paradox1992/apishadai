<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevicesEstados extends Model
{
    use HasFactory;

    protected $table = 'device_estado';
    protected $fillable = [
        'descripcion'
    ];


    public function Devices()
    {
        return $this->hasMany(Devices::class);
    }
}