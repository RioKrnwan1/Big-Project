<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

//Model Criteria - Merepresentasikan kriteria evaluasi untuk SPK
class Criteria extends Model
{
    use HasFactory;

    //Konstanta tipe atribut
    public const ATTRIBUTE_COST = 'cost';
    public const ATTRIBUTE_BENEFIT = 'benefit';

    //Atribut yang dapat diisi massal
    protected $fillable = [
        'code',
        'name',
        'attribute',
        'weight',
        'column_ref',
    ];

    //Atribut yang harus di-cast
    protected $casts = [
        'weight' => 'float',
    ];

    //Ambil sub-kriteria untuk kriteria ini
    public function subCriterias(): HasMany
    {
        return $this->hasMany(SubCriteria::class);
    }
}