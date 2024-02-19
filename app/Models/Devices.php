<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;
    protected $fillable = ['ip', 'stock', 'sts'];

    public function stock()
    {
        return $this->belongsTo(Stocks::class, 'stock');
    }
    public function status()
    {
        return $this->belongsTo(Devicestatus::class, 'sts');
    }

    public function rhoras()
    {
        return $this->hasMany(Rhoras::class, 'device', 'id');
    }

    public function cfgstocks()
    {
        return $this->hasMany(Cfgstocks::class, 'device', 'id');
    }

}