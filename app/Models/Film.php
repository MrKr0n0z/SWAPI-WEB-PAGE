<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'characters' => 'array',
        'planets' => 'array',
        'starships' => 'array',
        'vehicles' => 'array',
        'species' => 'array',
        'release_date' => 'date',
    ];
}
