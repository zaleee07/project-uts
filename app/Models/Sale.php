<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_number',
        'total',
        'status',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function scopeFilterDate(Builder $query, ?string $start, ?string $end): Builder
    {
        if ($start) {
            $query->whereDate('sold_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('sold_at', '<=', $end);
        }
        return $query;
    }
}
