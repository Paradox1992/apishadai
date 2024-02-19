<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rhoras extends Model
{
    use HasFactory;
    protected $table = 'rhoras';
    protected $fillable = ['usuario', 'device', 'entrada'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function device()
    {
        return $this->belongsTo(Devices::class);
    }
}