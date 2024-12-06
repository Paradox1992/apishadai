<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_estados extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
    ];

    public function User()
    {
        return $this->hasMany(User::class);
    }
}