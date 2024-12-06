<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horas_lab extends Model
{
    use HasFactory;
    protected  $table = "horas_lab";
    protected $fillable = [
        'usuario',
        'horas_lab',
        'horas_lunch',
    ];

    public function Usuario()
    {
        return $this->belongsTo(User::class,'id');
    }
}