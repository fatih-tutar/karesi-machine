<?php

namespace App\Models;

use App\Models\Concerns\HasIsDeletedFlag;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasIsDeletedFlag;

    protected $fillable = [
        'id',
        'name',
        'image',
        'video_url',
        'speed',
        'length',
        'height',
        'width',
        'weight_info',
        'recorded_on',
        'is_deleted',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'recorded_on' => 'date',
            'is_deleted' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
