<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'country',
        'city',
        'device',
        'browser',
        'is_unique',
    ];

    protected function casts(): array
    {
        return [
            'is_unique' => 'boolean',
        ];
    }
}
