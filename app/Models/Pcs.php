<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcs extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'name',
        'stock',
        'estado'
    ];



    public function estado()
    {
        return $this->belongsTo(pcs_estado::class, 'estado');
    }
    // stock
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock');
    }
}