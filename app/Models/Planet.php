<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'residents' => 'array',
        'films' => 'array',
    ];
}
