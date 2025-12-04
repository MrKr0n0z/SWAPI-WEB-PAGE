<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $table = 'species';
    protected $guarded = ['id'];

    protected $casts = [
        'people' => 'array',
        'films' => 'array',
    ];
}
