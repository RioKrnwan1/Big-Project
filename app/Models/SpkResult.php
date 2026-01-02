<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpkResult extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'result_data'
    ];

    protected $casts = [
        'result_data' => 'array',
    ];
}
