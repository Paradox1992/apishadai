<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pcs_estado extends Model
{
    use HasFactory;

    public function pcs()
    {

        return $this->hasMany(Pcs::class);
    }
}