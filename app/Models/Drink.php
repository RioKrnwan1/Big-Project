<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model Drink - Merepresentasikan alternatif minuman dalam sistem SPK
class Drink extends Model
{
    use HasFactory;

    //Atribut yang dapat diisi
    protected $fillable = [
        'name',
        'calories',
        'protein',
        'carbs',
        'fat',
    ];

    //Atribut yang harus di-cast
    protected $casts = [
        'calories' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
        'fat' => 'float',
    ];
}