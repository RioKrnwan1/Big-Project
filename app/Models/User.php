<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //Atribut yang dapat diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    //Atribut yang harus disembunyikan untuk serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //Atribut yang harus di-cast
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
