<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'empresa_id',
        'nombre',
        'email',
        'password',
        'tipo_id',
        'rol_id',
        'permisos',
        'activo',
        'telefono',
        'direccion',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
