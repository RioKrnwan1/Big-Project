<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Criteria Model - Represents evaluation criteria for SPK
 * 
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $attribute (cost|benefit)
 * @property float $weight
 * @property string $column_ref
 */
class Criteria extends Model
{
    use HasFactory;

    /**
     * Attribute types constants
     */
    public const ATTRIBUTE_COST = 'cost';
    public const ATTRIBUTE_BENEFIT = 'benefit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'attribute',
        'weight',
        'column_ref',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight' => 'float',
    ];

    /**
     * Get the sub-criterias for the criteria.
     */
    public function subCriterias(): HasMany
    {
        return $this->hasMany(SubCriteria::class);
    }
}