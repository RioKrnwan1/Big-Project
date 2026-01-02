<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Drink Model - Represents beverage alternatives in SPK system
 * 
 * @property int $id
 * @property string $name
 * @property float $calories
 * @property float $protein
 * @property float $carbs
 * @property float $fat
 * @property string|null $image
 */
class Drink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'calories',
        'protein',
        'carbs',
        'fat',
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'calories' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
        'fat' => 'float',
    ];
}