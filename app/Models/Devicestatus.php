<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devicestatus extends Model
{
    use HasFactory;
    protected $table = 'devicestatus';
    protected $fillable = ['descripcion'];
}
