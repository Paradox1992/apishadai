<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $fillable = [
        'ip',
        'ip2',
        'name',
        'stock',
        'estado',
    ];

    public function Estado()
    {
        return $this->belongsTo(DevicesEstados::class, 'estado');
    }

    public function Stock()
    {
        return $this->belongsTo(Stocks::class, 'stock');
    }

    public function MatchToken()
    {
        return $this->hasMany(MatchToken::class);
    }
}