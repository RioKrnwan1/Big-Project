<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comparison extends Model
{
    protected $fillable = [
        'name',
        'drink_ids',
        'notes'
    ];

    protected $casts = [
        'drink_ids' => 'array',
    ];

    //Ambil minuman yang terkait dengan perbandingan ini
    public function getDrinksAttribute()
    {
        if (empty($this->drink_ids)) {
            return collect();
        }

        return Drink::whereIn('id', $this->drink_ids)->get();
    }
}
