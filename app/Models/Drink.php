<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Drink Model - Represents beverage alternatives in SPK system
 * 
 * @property int $id
 * @property string $name
 * @property float $sugar
 * @property float $calories
 * @property float $fat
 * @property float $protein
 * @property float $carbs
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
        'sugar',
        'calories',
        'fat',
        'protein',
        'carbs',
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sugar' => 'float',
        'calories' => 'float',
        'fat' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
    ];
}