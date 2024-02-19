<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cfgstocks extends Model
{
    use HasFactory;

    public function device()
    {
        return $this->belongsTo(Devices::class);
    }

    public function config()
    {
        return $this->hasMany(Configs::class, 'cfg', 'id');
    }
}