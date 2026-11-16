<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Soft delete via the legacy `is_deleted` boolean column.
 */
trait HasIsDeletedFlag
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where($this->qualifyColumn('is_deleted'), false);
    }

    public function softDeleteFlag(): bool
    {
        return $this->update(['is_deleted' => true]);
    }
}
