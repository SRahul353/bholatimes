<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EPaper extends Model
{
    protected $table = 'epapers';

    protected $fillable = [
        'title',
        'publish_date',
        'page_number',
        'image',
        'layout_data',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'layout_data' => 'array',
    ];
}
