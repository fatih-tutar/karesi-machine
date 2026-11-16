<?php

namespace App\Models;

use App\Models\Concerns\HasIsDeletedFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountingEntry extends Model
{
    use HasIsDeletedFlag;

    public const TYPE_EXPENSE = 0;

    public const TYPE_INCOME = 1;

    protected $fillable = [
        'id',
        'type',
        'note',
        'material_id',
        'description',
        'amount_try',
        'amount_usd',
        'company_id',
        'project_id',
        'recorded_on',
        'is_deleted',
    ];

    protected function casts(): array
    {
        return [
            'type' => 'integer',
            'amount_try' => 'integer',
            'amount_usd' => 'decimal:2',
            'recorded_on' => 'date',
            'is_deleted' => 'boolean',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
