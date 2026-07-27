<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['id'];
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\OwnedByUserScope);

        static::creating(function ($company) {
            $company->user_id ??= auth()->id();
        });
    }

    public function customers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
