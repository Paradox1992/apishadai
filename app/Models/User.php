<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rol',
        'name',
        'email',
        'password',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function Rol()
    {
        return $this->belongsTo(RolesUser::class, 'rol');
    }

    public function Estado()
    {
        return $this->belongsTo(user_estados::class, 'estado');
    }

    public function MathcToken()
    {
        return $this->hasMany(MatchToken::class,'usuario');
    }

    public function Permisos()
    {
        return $this->hasMany(Permisos::class, 'usuario');
    }

    public function HoraLab(){
        return $this->hasMany(Horas_lab::class, 'usuario', 'id');
    }

    public function WorkSession(){
        return $this->hasMany(WorkSession::class, 'usuario');
    }
   
}