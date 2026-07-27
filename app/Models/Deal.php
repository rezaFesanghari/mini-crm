<?php

namespace App\Models;

use App\Models\Scopes\OwnedByUserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    protected $fillable = ['user_id', 'customer_id', 'title', 'value', 'stage'];

    protected static function booted(): void
    {
        static::addGlobalScope(new OwnedByUserScope);

        static::creating(function ($deal) {
            $deal->user_id ??= auth()->id();
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
