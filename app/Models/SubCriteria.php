<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//Model SubCriteria - Merepresentasikan rentang nilai untuk penilaian kriteria
class SubCriteria extends Model
{
    use HasFactory;

    //Atribut yang dapat diisi massal
    protected $fillable = [
        'criteria_id',
        'range_min',
        'range_max',
        'value',
    ];

    //Atribut yang harus di-cast
    protected $casts = [
        'criteria_id' => 'integer',
        'range_min' => 'float',
        'range_max' => 'float',
        'value' => 'integer',
    ];

    //Ambil kriteria yang memiliki sub-kriteria ini
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    //Scope untuk mencari sub-kriteria berdasarkan nilai dalam rentang
    public function scopeInRange($query, $value)
    {
        return $query->where('range_min', '<=', $value)
                     ->where('range_max', '>=', $value);
    }
}