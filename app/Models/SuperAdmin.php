<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SuperAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'email',
        'password',
        'reset_password_token',
        'reset_password_used',
    ];

    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
