<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matchtoken extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario',
        'pc',
        'token',
    ];
    // user relation
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
