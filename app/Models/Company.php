<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'id',
        'name',
        'recorded_on',
        'is_deleted',
    ];

    protected function casts(): array
    {
        return [
            'recorded_on' => 'date',
            'is_deleted' => 'boolean',
        ];
    }

    public function accountingEntries(): HasMany
    {
        return $this->hasMany(AccountingEntry::class);
    }
}
