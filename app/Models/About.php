<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'system_name',
        'version',
        'description',
        'developer_name',
        'last_updated'
    ];

    protected $casts = [
        'last_updated' => 'datetime'
    ];
}