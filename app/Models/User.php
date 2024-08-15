<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    public function rol()
    {
        return $this->belongsTo(roles::class, 'rol');
    }

    public function estado()
    {
        return $this->belongsTo(user_estados::class, 'estado');
    }

    public function permiso()
    {
        return $this->hasMany(permisos::class, 'usuario');
    }

    public function matchtoken()
    {
        return $this->hasMany(matchtoken::class, 'usuario');
    }


}
