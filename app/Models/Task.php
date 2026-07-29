<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\OwnedByUserScope);

        static::creating(function ($model) {
            $model->user_id ??= auth()->id();
        });
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
