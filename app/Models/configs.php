<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configs extends Model
{
    use HasFactory;

    public function cfg()
    {
        return $this->belongsTo(Cfgstocks::class, 'cfg');
    }
}