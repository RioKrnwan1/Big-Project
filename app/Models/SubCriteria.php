<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * SubCriteria Model - Represents value ranges for criteria scoring
 * 
 * @property int $id
 * @property int $criteria_id
 * @property float $range_min
 * @property float $range_max
 * @property int $value (1-5 scale)
 */
class SubCriteria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'criteria_id',
        'range_min',
        'range_max',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'criteria_id' => 'integer',
        'range_min' => 'float',
        'range_max' => 'float',
        'value' => 'integer',
    ];

    /**
     * Get the criteria that owns the sub-criteria.
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Scope to find sub-criteria by value in range
     */
    public function scopeInRange($query, $value)
    {
        return $query->where('range_min', '<=', $value)
                     ->where('range_max', '>=', $value);
    }
}