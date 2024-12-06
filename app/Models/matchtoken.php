<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchToken extends Model
{
    use HasFactory;
    protected $table = 'matchtokens';
    protected $fillable = [
        'usuario',
        'device',
        'token'
    ];

    public function Device()
    {
        return $this->belongsTo(Devices::class, 'device');
    }

    public function Usuario()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}