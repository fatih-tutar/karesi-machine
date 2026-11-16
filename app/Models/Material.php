<?php

namespace App\Models;

use App\Models\Concerns\HasIsDeletedFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasIsDeletedFlag;

    protected $fillable = [
        'id',
        'name',
        'recorded_on',
        'include_in_reports',
        'is_deleted',
    ];

    protected function casts(): array
    {
        return [
            'recorded_on' => 'date',
            'include_in_reports' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function accountingEntries(): HasMany
    {
        return $this->hasMany(AccountingEntry::class);
    }
}
